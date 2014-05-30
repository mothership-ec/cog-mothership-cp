<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\ValueObject\DateTimeImmutable;

class KeyValueDataset extends Dataset
{
	public function getTable()
	{
		return "statistic_key_value";
	}

	public function add($key, $value)
	{
		$this->_query->run("
			INSERT INTO " . $this->getTable() . " (
				`dataset`,
				`key`,
				`value`,
				`created_at`
			)
			VALUES (
				:dataset?s,
				:key?s,
				:value?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->getName(),
			'key'       => $key,
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);
	}

	public function getAverage($startTime, $endTime = null)
	{
		list($startTime, $endTime) = $this->_getTimeRange($startTime, $endTime);

		$result = $this->_query->run("
			SELECT
				AVG(`value`) as average
			FROM
				" . $this->getTable() . "
			WHERE
				`dataset`     = :dataset?s
			AND	`created_at` >= :startDate?d
			AND	`created_at` <= :endDate?d
		", [
			'dataset'   => $this->getName(),
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime),
		]);

		return $result[0]->average;
	}

	public function getTotal($startTime, $endTime = null)
	{
		list($startTime, $endTime) = $this->_getTimeRange($startTime, $endTime);

		$result = $this->_query->run("
			SELECT
				SUM(value) as total
			FROM
				" . $this->getTable() . "
			WHERE
				dataset       = :dataset?s
			AND	`created_at` >= :startDate?d
			AND	`created_at` <= :endDate?d
		", [
			'dataset'   => $this->getName(),
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime),
		]);

		return $result[0]->total;
	}
}