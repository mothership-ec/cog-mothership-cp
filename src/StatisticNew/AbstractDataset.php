<?php

interface DatasetInterface
{
	public function getName();
	public function rebuild($from = null, $to = null);
}

class AbstractDataset implements DatasetInterface, TransactionalInterface
{
	protected $_query;
	protected $_transactionOverridden = false;

	public function setTransaction(Transaction $query)
	{
		$this->_query = $query;
		$this->_transactionOverridden = true;
	}

	public function set($key, $value = null)
	{
		$key = trim($this->getName() . '.' . $key, '.');

		if (null === $value) {
			$value = $key;
		}

		$this->_query->run("
			REPLACE INTO statistic (
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
				:value?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->getName(),
			'key'       => $key,
			'period'    => (in_array('PeriodTrait', class_uses($this))) ? $this->getCurrentPeriod() : null,
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);

		if (! $this->_transactionOverriden) {
			$this->_query->commit();
		}

		return $this;
	}

	public function get($key = null)
	{
		$key = trim($this->getName() . '.' . $key, '.');

		$result = $this->_query("some select query");

		return $result;
	}
}

trait CounterTrait {
	public function increment($value = 1)
	{
		$this->set($this->get() + $value);
	}

	public function decrement($value = 1)
	{
		$this->set($this->get() - $value);
	}
}

trait KeyCounterTrait {
	public function increment($key, $value = 1)
	{
		$this->set($key, $this->get($key) + $value);
	}

	public function decrement($key, $value = 1)
	{
		$this->set($key, $this->get($key) - $value);
	}
}

trait PeriodTrait implements PeriodInterface {
	const HOURLY = 3600;   // 60 * 60
	const DAILY  = 86400;  // 60 * 60 * 24
	const WEEKLY = 604800; // 60 * 60 * 24 * 7

	const HOUR_AGO = 'hour';
	const DAY_AGO  = 'day';
	const WEEK_AGO = 'week';

	abstract public function getPeriod();

	public function getCurrentPeriod()
	{
		return time() - (time() % $this->getPeriod());
	}

	public function getRange($from, $to = null)
	{
		$to = ($to) ?: time();

		switch ($from) {
			case static::HOUR_AGO:
				$from = $to - static::HOURLY;
				break;
			case static::DAY_AGO:
				$from = $to - static::DAILY;
				break;
			case static::WEEK_AGO:
				$from = $to - static::WEEKLY;
				break;
		}

		if ($from > $to) {
			throw new InvalidArgumentException("Invalid 'from' time, can not be
				more recent than 'to' time");
		}
	}

	public function getLastHour($to = null)
	{
		return $this->getRange(static::HOUR_AGO, $to);
	}

	public function getLastDay($to = null)
	{
		return $this->getRange(static::DAY_AGO, $to);
	}

	public function getLastWeek($to = null)
	{
		return $this->getRange(static::WEEK_AGO, $to);
	}
}

class OrdersInWeekly extends AbstractDataset
{
	use CounterTrait, PeriodTrait;

	public function __construct($query)
	{
		$this->_query = $query;
	}

	public function getName()
	{
		return 'orders.in.weekly';
	}

	public function getPeriod()
	{
		return PeriodTrait::WEEKLY;
	}

	public function rebuild($from = null, $to = null)
	{

	}
}

new OrdersInWeekly($c['db.query']);

$dataset = $this->get('statistics')->get('orders.in.weekly');
$dataset->increment('uk', 1);
$dataset->getLastWeek();