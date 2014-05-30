<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

class KeyCounterDataset extends CounterDataset
{
	protected $_key = [];
	protected $_counter = [];

	public function getTable()
	{
		return "statistic_key_counter";
	}

	public function getKeyCounter($key)
	{
		$dirty = ! (isset($this->_dirty[$key]) and $this->_dirty[$key]);

		if ($dirty) {
			$result = $this->_query->run("
				SELECT
					value
				FROM
					" . $this->getTable() . "
				WHERE
					`dataset` = :dataset?s
				AND	`key`     = :key?s
				AND	`period`  = :period?d
			", [
				'dataset' => $this->getName(),
				'key'     => $key,
				'period'  => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
			]);

			$this->_keyCounter[$key] = 0;
			if (count($result)) {
				$this->_keyCounter[$key] = $result[0]->value;
			}

			$this->_keyDirty[$key] = false;
		}

		return $this->_keyCounter[$key];
	}

	public function setKeyCounter($key, $counter)
	{
		$this->_query->run("
			REPLACE INTO " . $this->getTable() . " (
				`dataset`,
				`key`,
				`period`,
				`value`,
				`created_at`
			)
			VALUES (
				:dataset?s,
				:key?s,
				:period?d,
				:counter?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->getName(),
			'key'       => $key,
			'period'    => new DateTimeImmutable('@'.$this->getCurrentPeriod()),
			'counter'   => $counter,
			'createdAt' => new DateTimeImmutable
		]);

		$this->_keyDirty = true;

		return $this;
	}

	public function incrementKey($key, $amount = 1)
	{
		return $this->setKeyCounter($key, $this->getKeyCounter($key) + $amount);
	}

	public function decrementKey($key, $amount = 1)
	{
		return $this->setKeyCounter($key, $this->getKeyCounter($key) - $amount);
	}

	public function getKeyRange($startTime, $endTime = null)
	{
		list($startTime, $endTime) = $this->_getTimeRange($startTime, $endTime);

		$result = $this->_query->run("
			SELECT
				`key`,
				`value`
			FROM
				" . $this->getTable() . "
			WHERE
				`dataset`  = :dataset?s
			AND	`period`  >= :startDate?d
			AND	`period`  <= :endDate?d
		", [
			'dataset'   => $this->getName(),
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime)
		]);

		$range = [];
		foreach ($result as $r) {
			$range[$r->key] = $r->value;
		}

		return $range;
	}
}