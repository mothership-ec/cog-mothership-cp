<?php

namespace Message\Mothership\ControlPanel\Test\Statistic;

use Mockery as m;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

use Message\Cog\ValueObject\DateTimeImmutable;

class CounterTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_counter;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\QueryableInterface');

		$this->_counter = m::mock('Message\Mothership\ControlPanel\Statistic\Counter[set,push,get]', [$this->_query]);
	}

	public function testIncrement()
	{
		$startValue = 1;
		$expectedValue = 2;

		$this->_counter
			->shouldReceive('get')
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('push')
			->with($expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->increment(), $expectedValue);
	}

	public function testIncrementByStep()
	{
		$startValue = 1;
		$step = 2;
		$expectedValue = 3;

		$this->_counter
			->shouldReceive('get')
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('push')
			->with($expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->increment($step), $expectedValue);
	}

	public function testDecrement()
	{
		$startValue = 2;
		$expectedValue = 1;

		$this->_counter
			->shouldReceive('get')
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('push')
			->with($expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->decrement(), $expectedValue);
	}

	public function testDecrementByStep()
	{
		$startValue = 3;
		$step = 2;
		$expectedValue = 1;

		$this->_counter
			->shouldReceive('get')
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('push')
			->with($expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->decrement($step), $expectedValue);
	}
}