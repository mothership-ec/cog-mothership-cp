<?php

class AbstractDataset($name, AbstractCounter, Period) implements TransactionalInterface;
class AbstractCounter(Query) implements TransactionalInterface::setPeriodLength,setPeriodWeekly,getCurrentPeriod;
class Counter extends AbstractCounter::increment($step=1),decrement($step=-1);
class KeyCounter extends AbstractCounter::increment($key,$step=1),decrement($key,$step=-1);
class Period(Query) implements TransactionalInterface::getHour($ago=-1),getDay,getWeek,getMonth,getYear,getRange($from,$to=null);


$c['statistic.counter'] = function($c) {
	return new Counter($c['db.query']);
}

$c['statistic.counter.weekly'] = function($c) {
	$counter = $c['statistic.counter'];
	$counter->setPeriodLength($counter::WEEKLY);
	return $counter;
}

$c['statistic.range.date'] = function($c) {
	return new DateRange($c['db.query']);
}

$dataset = new MyDataset('my.dataset', $c['statistic.counter.weekly'], $c['statistic.range.date']);
$dataset->counter->increment(1);
$dataset->range->getWeek();



abstract class AbstractDataset
{
	const HOURLY  = 60 * 60;
	const DAILY   = 60 * 60 * 24;
	const WEEKLY  = 60 * 60 * 24 * 7;
	const MONTHLY = 60 * 60 * 24 * 30;
	const YEARLY  = 60 * 60 * 24 * 365;

	public $counter;
	public $range;

	public function __construct(CounterInterface $counter, RangeInterface $range)
	{
		$counter->setDatasetName($this->getName());
		$counter->setPeriodLength($this->getPeriodLength());

		$range->setDatasetName($this->getName());

		$this->counter = $counter;
		$this->range   = $range;
	}

	abstract public function getName();
	abstract public function getPeriodLength();
	abstract public function rebuild();
}

interface CounterInterface
{
	public function setDatasetName($datasetName);
	public function setPeriodLength($length);
	public function getPeriod($ago = -1);
	public function set($key, $value);
	public function push($value);
}

abstract class AbstractCounter implements CounterInterface
{
	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
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

	public function setPeriodLength($periodLength)
	{
		$this->_periodLength = $periodLength;

		return $this;
	}

	public function getPeriodLength()
	{
		return $this->_periodLength;
	}

	public function getPeriod($ago = 0)
	{
		if ($ago > 0) throw new InvalidArgumentException("Period ago can not be in the future");

		$currentPeriod = time() - (time() % $this->getPeriodLength());

		$period = $currentPeriod - ($this->getPeriodLength() * $ago);

		return $period;
	}

	public function set($key, $value)
	{
		$key = trim($this->getDatasetName() . '.' . $key, '.');

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
				:key?s
				:period?d
				:value?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->getDatasetName(),
			'key'       => $key,
			'period'    => new DateTimeImmutable(date('c', $this->getPeriod())),
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);
	}

	public function push($value)
	{
		return $this->set('', $value);
	}

	public function get($key = null)
	{
		$key = trim($this->getDatasetName() . '.' . $key, '.');

		$result = $this->_query->run("
			SELECT
				value
			FROM
				statistic
			WHERE
				`dataset` = :dataset?s
			AND	`key`     = :key?s
			AND	`period` >= :period?d
		", [
			'dataset' => $this->getName(),
			'key'     => $key,
			'period'  => new DateTimeImmutable(date('c', $this->getCurrentPeriod())),
		]);

		if (0 == count($result)) {
			return 0;
		}

		return $result[0]->value;
	}
}

class Counter extends AbstractCounter
{
	public function increment($step = 1)
	{
		$value = $this->get() + $step;

		return $this->push($value);
	}

	public function decrement($step = 1)
	{
		$value = $this->get() - $step;

		return $this->push($value);
	}
}

class KeyCounter extends AbstractCounter
{
	public function increment($key, $step = 1)
	{
		$value = $this->get($key) + $step;

		return $this->push($value);
	}

	public function decrement($key, $step = 1)
	{
		$value = $this->get($key) - $step;

		return $this->push($value);
	}
}

interface RangeInterface
{
	public function getValues($from, $to = null);
	public function getAverage($from, $to = null);
	public function getTotal($from, $to = null);
}

class DateRange implements RangeInterface
{
	const HOUR  = 60 * 60;
	const DAY   = 60 * 60 * 24;
	const WEEK  = 60 * 60 * 24 * 7;
	const MONTH = 60 * 60 * 24 * 30;
	const YEAR  = 60 * 60 * 24 * 365;

	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
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

		$result = $this->_query->run("
			SELECT
				value
			FROM
				statistic
			WHERE
				`dataset`  = :dataset?s
				`period`  >= :from?d
				`period   <= :to?d
		", [
			'dataset' => $this->getDatasetName(),
			'from'    => new DateTimeImmutable(date('c', $from)),
			'to'      => new DateTimeImmutable(date('c', $to)),
		]);

		$values = $result->flatten('value');

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

	public function getHour($ago = -1)
	{
		return $this->getValues($ago * static::HOUR);
	}

	public function getDay($ago = -1)
	{
		return $this->getValues($ago * static::DAY);
	}

	public function getWeek($ago = -1)
	{
		return $this->getValues($ago * static::WEEK);
	}

	public function getMonth($ago = -1)
	{
		return $this->getValues($ago * static::MONTH);
	}

	public function getYear($ago = -1)
	{
		return $this->getValues($ago * static::YEAR);
	}
}

class OrdersIn extends AbstractDataset
{
	public function getName()
	{
		return 'orders.in';
	}

	public function getPeriodLength()
	{
		return static::DAILY;
	}

	public function rebuild()
	{

	}
}


$ordersIn = new OrdersIn('orders.in', $c['statistic.counter'], $c['statistic.range.date']);

$ordersIn->counter->push(1);

$ordersIn->range->getWeek();