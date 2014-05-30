<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

class CounterDataset extends Dataset
{
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

	public function getTable()
	{
		return "statistic_counter";
	}

	public function getPeriod()
	{
		return $this->_period;
	}

	public function getCurrentPeriod()
	{
		return time() - (time() % $this->getPeriod());
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
					" . $this->getTable() . "
				WHERE
					`dataset` = :dataset?s
				AND	`period` >= :period?d
			", [
				'dataset' => $this->getName(),
				'period'  => new DateTimeImmutable(date('c', $this->getCurrentPeriod())),
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
			REPLACE INTO " . $this->getTable() . " (
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
			'dataset'   => $this->getName(),
			'period'    => new DateTimeImmutable(date('c', $this->getCurrentPeriod())),
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

	public function getRange($from, $to = null)
	{
		list($from, $to) = $this->_getTimeRange($from, $to);

		$result = $this->_query->run("
			SELECT
				`period`,
				`value`
			FROM
				" . $this->getTable() . "
			WHERE
				`dataset`  = :dataset?s
			AND	`period`  >= :startDate?d
			AND	`period`  <= :endDate?d
		", [
			'dataset'   => $this->getName(),
			'startDate' => new DateTimeImmutable(date('c', $from)),
			'endDate'   => new DateTimeImmutable(date('c', $to))
		]);

		$range = [];
		foreach ($result as $r) {
			$range[$r->period] = $r->value;
		}

		return $range;
	}

	public function getAverage($from, $to = null)
	{
		$range = $this->getRange($from, $to);

		$average = 0;

		if (count($range)) {
			$average = array_sum($range) / count($range);
		}

		return $average;
	}

	public function getTotal($from, $to = null)
	{
		$range = $this->getRange($from, $to);

		$total = array_sum($range);

		return $total;
	}
}