<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

abstract class Dataset
{
	const TABLE = null;

	const HOUR_AGO = 'hour';
	const DAY_AGO  = 'day';
	const WEEK_AGO = 'week';

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

	public function rebuild()
	{

	}

	protected function _getTimeRange($startTime, $endTime = null)
	{
		$endTime = ($endTime) ?: time();

		foreach ([
			'startTime' => $startTime,
			'endTime'   => $endTime
		] as $var => $time) {
			if (is_string($time)) {
				switch ($time) {
					case static::HOUR_AGO:
						$time = $endTime - 60 * 60;
						break;
					case static::DAY_AGO:
						$time = $endTime - 60 * 60 * 24;
						break;
					case static::WEEK_AGO:
						$time = $endTime - 60 * 60 * 24 * 7;
						break;
				}
			}

			$$var = $time;
		}

		return [$startTime, $endTime];
	}
}