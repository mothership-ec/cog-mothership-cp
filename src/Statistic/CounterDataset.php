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
					statistics
				WHERE
					`dataset` = :dataset?s
				AND	`key`     = :currentPeriod?s
			", [
				'dataset'       => $this->_name,
				'currentPeriod' => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
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
			REPLACE INTO statistics (
				`dataset`,
				`key`,
				`value`,
				`createdAt`
			)
			VALUES (
				:dataset?s,
				:currentPeriod?d,
				:counter?f,
				:createdAt?d
			)
		", [
			'dataset'       => $this->_name,
			'currentPeriod' => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
			'counter'       => $counter,
			'createdAt'     => new DateTimeImmutable
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
}