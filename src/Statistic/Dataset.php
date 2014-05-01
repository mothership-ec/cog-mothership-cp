<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

abstract class Dataset
{
	const HOUR = 'hour';
	const DAY  = 'day';
	const WEEK = 'week';

	protected $_query;
	protected $_name;

	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}

	public function getRange($startTime, $endTime = null)
	{
		$endTime = ($endTime) ?: time();

		foreach ([
			'startTime' => $startTime,
			'endTime'   => $endTime
		] as $var => $time) {
			if (is_string($time)) {
				switch ($time) {
					case static::HOUR:
						$time = $endTime - 60 * 60;
						break;
					case static::DAY:
						$time = $endTime - 60 * 60 * 24;
						break;
					case static::WEEK:
						$time = $endTime - 60 * 60 * 24 * 7;
						break;
				}
			}

			$$var = $time;
		}

		$result = $this->_query->run("
			SELECT
				`key`,
				`value`
			FROM
				statistics
			WHERE
				`dataset`    = :dataset?s
			AND	`created_at` >= :startDate?d
			AND	`created_at` <= :endDate?d
		", [
			'dataset'   => $this->_name,
			'startDate' => new DateTimeImmutable('@'.$startTime),
			'endDate'   => new DateTimeImmutable('@'.$endTime)
		]);

		$range = [];
		foreach ($result as $r) {
			$range[$r->key] = $r->value;
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