<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

class CounterDataset extends Dataset
{
	const TABLE = "statistic_counter";

	protected $_dirty;
	protected $_counter;
	protected $_period;

	public function __construct(QueryableInterface $query)
	{
		parent::__construct($query);

		$this->_dirty   = true;
		$this->_counter = 0;
		$this->_period  = 60 * 60;
	}

	public function getPeriod()
	{
		return $this->_period;
	}

	public function getCurrentPeriod()
	{
		return time() - (time() % $this->_period);
	}

	public function setPeriod($period)
	{
		$this->_period = $period;

		return $this;
	}

	public function getCounter()
	{
		if ($this->_dirty) {
			$result = $this->_query->run("
				SELECT
					value
				FROM
					" . static::TABLE . "
				WHERE
					`dataset` = :dataset?s
				AND	`period`  = :period?s
			", [
				'dataset' => $this->_name,
				'period' => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
			]);

			$this->_counter = 0;
			if (count($result)) {
				$this->_counter = $result[0]->value;
			}

			$this->_dirty = false;
		}

		return $this->_counter;
	}

	public function setCounter($counter)
	{
		$this->_query->run("
			REPLACE INTO " . static::TABLE . " (
				`dataset`,
				`period`,
				`value`,
				`created_at`
			)
			VALUES (
				:dataset?s,
				:period?d,
				:counter?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->_name,
			'period'    => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
			'counter'   => $counter,
			'createdAt' => new DateTimeImmutable
		]);

		$this->_dirty = true;

		return $this;
	}

	public function increment($amount = 1)
	{
		return $this->setCounter($this->getCounter() + $amount);
	}

	public function decrement($amount = 1)
	{
		return $this->setCounter($this->getCounter() - $amount);
	}

	public function getRange($startTime, $endTime = null)
	{
		list($startTime, $endTime) = $this->_getTimeRange($startTime, $endTime);

		$result = $this->_query->run("
			SELECT
				`period`,
				`value`
			FROM
				" . static::TABLE . "
			WHERE
				`dataset`  = :dataset?s
			AND	`period`  >= :startDate?d
			AND	`period`  <= :endDate?d
		", [
			'dataset'   => $this->_name,
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime)
		]);

		$range = [];
		foreach ($result as $r) {
			$range[$r->period] = $r->value;
		}

		return $range;
	}

	public function getAverage($startTime, $endTime = null)
	{
		$range = $this->getRange($startTime, $endTime);

		$average = 0;

		if (count($range)) {
			$average = array_sum($range) / count($range);
		}

		return $average;
	}

	public function getTotal($startTime, $endTime = null)
	{
		$range = $this->getRange($startTime, $endTime);

		$total = array_sum($range);

		return $total;
	}
}