<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;
use Message\Cog\ValueObject\DateTimeImmutable;

abstract class Dataset implements TransactionalInterface
{
	const HOURLY  = 'hourly';
	const DAILY   = 'daily';
	const WEEKLY  = 'weekly';
	const MONTHLY = 'monthly';
	const YEARLY  = 'yearly';

	const HOUR_AGO  = 'hour_ago';
	const DAY_AGO   = 'day_ago';
	const WEEK_AGO  = 'week_ago';
	const MONTH_AGO = 'month_ago';
	const YEAR_AGO  = 'year_ago';

	protected $_query;
	protected $_name;

	protected $_transOverriden;

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

	abstract public function getTable();

	public function setTransaction(Transaction $trans)
	{
		$this->_query = $trans;
		$this->_transOverriden = true;
	}

	public function rebuild()
	{

	}

	protected function _getTimeRange($from, $to = null)
	{
		$to = ($to) ?: time();

		switch ($from) {
			case static::HOUR_AGO:
				$from = $to - 60 * 60;
				break;
			case static::DAY_AGO:
				$from = $to - 60 * 60 * 24;
				break;
			case static::WEEK_AGO:
				$from = $to - 60 * 60 * 24 * 7;
				break;
			case static::MONTH_AGO:
				$from = $to - 60 * 60 * 24 * 7 * 30;
				break;
			case static::YEAR_AGO:
				$from = $to - 60 * 60 * 24 * 7 * 365;
				break;
		}

		return [$from, $to];
	}
}