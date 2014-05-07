<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\ValueObject\DateTimeImmutable;

class KeyValueDataset extends Dataset
{
	const TABLE = "statistic_key_value";

	public function add($key, $value)
	{
		$this->_query->run("
			INSERT INTO " . static::TABLE . " (
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
			'dataset'   => $this->_name,
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
				" . static::TABLE . "
			WHERE
				`dataset`     = :dataset?s
			AND	`created_at` >= :startDate?d
			AND	`created_at` <= :endDate?d
		", [
			'dataset'   => $this->_name,
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
				" . static::TABLE . "
			WHERE
				dataset       = :dataset?s
			AND	`created_at` >= :startDate?d
			AND	`created_at` <= :endDate?d
		", [
			'dataset'   => $this->_name,
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime),
		]);

		return $result[0]->total;
	}
}