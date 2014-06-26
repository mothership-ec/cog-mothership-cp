<?php

namespace Message\Mothership\ControlPanel\Statistic;

use InvalidArgumentException;
use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

/**
 * Basic range implementation with additonal date helpers.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
class DateRange implements RangeInterface, TransactionalInterface
{
	const HOUR  = 3600; // 60 * 60;
	const DAY   = 86400; // 60 * 60 * 24;
	const WEEK  = 604800; // 60 * 60 * 24 * 7;
	const MONTH = 2592000; // 60 * 60 * 24 * 30;
	const YEAR  = 31536000; // 60 * 60 * 24 * 365;

	/**
	 * Constructor.
	 *
	 * @param QueryableInterface $query
	 */
	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setTransaction(Transaction $trans)
	{
		$this->_query = $trans;
		$this->_transOverriden = true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setDatasetName($datasetName)
	{
		$this->_datasetName = $datasetName;

		return $this;
	}

	/**
	 * Get the dataset name.
	 *
	 * @return string
	 */
	public function getDatasetName()
	{
		return $this->_datasetName;
	}

	/**
	 * {@inheritDoc}
	 */
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

	public function getKeyValues($from, $to = null)
	{
		$to = ($to) ?: time();

		if ($from > $to) {
			throw new InvalidArgumentException(sprintf("Invalid 'from' time, can
				not be more recent than 'to' time: %d, %d", $from, $to));
		}

		$result = $this->_query->run("
			SELECT
				SUM(`value`) as `value`,
				REPLACE(`key`, CONCAT(:dataset?s, '.'), '') as `key`
			FROM
				statistic
			WHERE
				`dataset`  = :dataset?s
			AND	`period`  >= :from?d
			AND	`period`  <= :to?d
			GROUP BY
				`key`
		", [
			'dataset' => $this->getDatasetName(),
			'from'    => new DateTimeImmutable(date('c', $from)),
			'to'      => new DateTimeImmutable(date('c', $to)),
		]);

		$values = [];

		foreach ($result as $row) {
			$values[$row->key] = (float) $row->value;
		}

		return $values;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAverage($from, $to = null)
	{
		$values = $this->getValues($from, $to);

		if (0 == count($values)) {
			return 0;
		}

		return array_sum($values) / count($values);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTotal($from, $to = null)
	{
		$values = $this->getValues($from, $to);

		return array_sum($values);
	}

	/**
	 * Get the timestamp of a number of hours ago at the hour division.
	 *
	 * @param  int $ago Number of hours ago.
	 * @return int
	 */
	public function getHourAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::HOUR, static::HOUR);
	}

	/**
	 * Get the timestamp of a number of days ago at the day division.
	 *
	 * @param  int $ago Number of days ago.
	 * @return int
	 */
	public function getDayAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::DAY, static::DAY);
	}

	/**
	 * Get the timestamp of a number of weeks ago at the day division.
	 *
	 * @param  int $ago Number of weeks ago.
	 * @return int
	 */
	public function getWeekAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::WEEK, static::DAY);
	}

	/**
	 * Get the timestamp of a number of months ago at the day division.
	 *
	 * @param  int $ago Number of months ago.
	 * @return int
	 */
	public function getMonthAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::MONTH, static::DAY);
	}

	/**
	 * Get the timestamp of a number of year ago at the day division.
	 *
	 * @param  int $ago Number of years ago.
	 * @return int
	 */
	public function getYearAgo($ago = 0)
	{
		return $this->getTimeAgo($ago, static::YEAR, static::DAY);
	}

	/**
	 * Get the timestamp of a period ago, rounded down to the start of the
	 * division.
	 *
	 * @param  int $ago    Number of periods ago.
	 * @param  int $period Length of the period in seconds.
	 * @param  int $round  Division to round down to in seconds.
	 * @return int
	 */
	public function getTimeAgo($ago = 0, $period, $round)
	{
		return time() - (time() % $round) + ($ago - 1) * $period;
	}
}