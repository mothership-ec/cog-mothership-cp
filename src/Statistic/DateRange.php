<?php

namespace Message\Mothership\ControlPanel\Statistic;

use InvalidArgumentException;
use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

class DateRange implements RangeInterface, TransactionalInterface
{
	const HOUR  = 3600; // 60 * 60;
	const DAY   = 86400; // 60 * 60 * 24;
	const WEEK  = 604800; // 60 * 60 * 24 * 7;
	const MONTH = 2592000; // 60 * 60 * 24 * 30;
	const YEAR  = 31536000; // 60 * 60 * 24 * 365;

	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	public function setTransaction(Transaction $trans)
	{
		$this->_query = $trans;
		$this->_transOverriden = true;
	}

	public function setDatasetName($datasetName)
	{
		$this->_datasetName = $datasetName;

		return $this;
	}

	public function getDatasetName()
	{
		return $this->_datasetName;
	}

	public function getValues($from, $to = null)
	{
		$to = ($to) ?: time();

		if ($from > $to) {
			throw new InvalidArgumentException(sprintf("Invalid 'from' time, can
				not be more recent than 'to' time: %d, %d", $from, $to));
		}

		$result = $this->_query->run("
			SELECT
				value,
				period
			FROM
				statistic
			WHERE
				`dataset`  = :dataset?s
			AND	`period`  >= :from?d
			AND	`period`  <= :to?d
		", [
			'dataset' => $this->getDatasetName(),
			'from'    => new DateTimeImmutable(date('c', $from)),
			'to'      => new DateTimeImmutable(date('c', $to)),
		]);

		$values = [];

		foreach ($result as $row) {
			$values[$row->period] = (float) $row->value;
		}

		return $values;
	}

	public function getAverage($from, $to = null)
	{
		$values = $this->getValues($from, $to);

		return array_sum($values) / count($values);
	}

	public function getTotal($from, $to = null)
	{
		$values = $this->getValues($from, $to);

		return array_sum($values);
	}

	public function getHourAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::HOUR, static::HOUR);
	}

	public function getDayAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::DAY, static::DAY);
	}

	public function getWeekAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::WEEK, static::DAY);
	}

	public function getMonthAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::MONTH, static::DAY);
	}

	public function getYearAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::YEAR, static::DAY);
	}

	public function getTimeAgo($ago = 0, $period, $round)
	{
		return time() - (time() % $round) + ($ago - 1) * $period;
	}
}