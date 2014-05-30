<?php

abstract class AbstractDataset
{
	public function __construct($name, $query, $counter, $finder)
	{
		$counter->setRootKey($name);

		// pass transaction to counter as well

		$this->_name    = $name;
		$this->_query   = $query;
		$this->_counter = $counter;
		$this->_finder  = $finder;
	}
}

abstract class AbstractCounter
{
	public function set($key, $value)
	{
		$key = trim($this->getRootKey() . '.' . $key, '.');

		// not sure how to do the insert here while also checking for the period
	}

	public function get($key = null)
	{
		$key = trim($this->getName() . '.' . $key, '.');

		$result = $this->_query("some select query");

		return $result;
	}
}

class Counter extends AbstractCounter
{
	public function increment($value = 1)
	{
		$this->set(null, $this->get() + $value);
	}

	public function decrement($value = 1)
	{
		$this->set(null, $this->get() - $value);
	}
}

class KeyCounter extends AbstractCounter
{
	public function increment($key, $value = 1)
	{
		$this->set($key, $this->get($key) + $value);
	}

	public function decrement($key, $value = 1)
	{
		$this->set($key, $this->get($key) - $value);
	}
}

// Finder? Reader? Something else?
class Finder
{
	public function getRange();
	public function getAverage();
	public function getTotal();
}

class Period extends Finder
{
	const HOURLY = 3600;   // 60 * 60
	const DAILY  = 86400;  // 60 * 60 * 24
	const WEEKLY = 604800; // 60 * 60 * 24 * 7

	const HOUR_AGO = 'hour';
	const DAY_AGO  = 'day';
	const WEEK_AGO = 'week';

	protected $_length;

	public function setLength($length)
	{
		$this->_length = $length;

		return $this;
	}

	public function setLengthHourly()
	{
		return $this->setLength(static::HOURLY);
	}

	public function setLengthDaily()
	{
		return $this->setLength(static::DAILY);
	}

	public function setLengthWeekly()
	{
		return $this->setLength(static::WEEKLY);
	}

	public function getLength()
	{
		return $this->_length;
	}

	public function getCurrentPeriod()
	{
		return time() - (time() % $this->getLength());
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
				$from = $to - static::WEEK_AGO;
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
	public function getName()
	{
		return 'orders.in.weekly';
	}

	public function rebuild()
	{

	}
}

new OrdersInWeekly($c['db.query'], $c['statistic.keycounter'], $c['statistic.period']->setLengthHourly());

$dataset = $this->get('statistics')->get('orders.in.weekly');
$dataset->getCounter()->increment('uk', 1);
$dataset->getFinder()->getLastWeek();