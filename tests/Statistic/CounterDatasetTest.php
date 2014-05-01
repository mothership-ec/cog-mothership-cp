<?php

namespace Message\Mothership\ControlPanel\Test\Statistic;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Message\Cog\DB\Adapter\Faux\Connection as FauxConnection;
use Message\Mothership\ControlPanel\Statistic\CounterDataset;

class CounterDatasetTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_dataset;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\QueryableInterface');

		$this->_dataset = new CounterDataset($this->_query);
	}

	public function testGetPeriod()
	{
		$this->assertSame(60 * 60 * 24, $this->_dataset->getPeriod());
	}

	public function testSetPeriod()
	{
		$period = 60 * 60 * 24 * 7;

		$this->_dataset->setPeriod($period);

		$this->assertSame($period, $this->_dataset->getPeriod());
	}

	public function testGetCounter()
	{
		$this->_query
			->shouldReceive('run')
			->andReturn([
				(object) [
					'value' => 0
				]
			]);
		$this->assertSame(0, $this->_dataset->getCounter());
	}

	public function testSetCounter()
	{
		$name    = 'test';
		$counter = 10;
		$this->_dataset->setName($name);

		$this->_query
			->shouldReceive('run')
			->andReturn(null);

		$this->_dataset->setCounter($counter);
	}

	public function testIncrement()
	{
		$newCounter = $this->_dataset->setCounter(10)->increment();

		$this->assertSame(11, $newCounter);
	}

	public function testDecrement()
	{
		$newCounter = $this->_dataset->setCounter(10)->decrement();

		$this->assertSame(9, $newCounter);
	}

	public function testIncrementByAmount()
	{
		$newCounter = $this->_dataset->setCounter(10)->increment(4);

		$this->assertSame(14, $newCounter);
	}

	public function testDecrementByAmount()
	{
		$newCounter = $this->_dataset->setCounter(10)->decrement(4);

		$this->assertSame(6, $newCounter);
	}
}