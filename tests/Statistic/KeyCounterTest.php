<?php

namespace Message\Mothership\ControlPanel\Test\Statistic;

use Mockery as m;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

use Message\Cog\ValueObject\DateTimeImmutable;
use Message\Cog\DB\Adapter\Faux\Connection as FauxConnection;

class KeyCounterTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_counter;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\QueryableInterface');

		$this->_counter = m::mock('Message\Mothership\ControlPanel\Statistic\KeyCounter[set,push,get]', [$this->_query]);
	}

	public function testIncrement()
	{
		$key = 'key';
		$startValue = 1;
		$expectedValue = 2;

		$this->_counter
			->shouldReceive('get')
			->with($key)
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('set')
			->with($key, $expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->increment($key), $expectedValue);
	}

	public function testIncrementByStep()
	{
		$key = 'key';
		$startValue = 1;
		$step = 2;
		$expectedValue = 3;

		$this->_counter
			->shouldReceive('get')
			->with($key)
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('set')
			->with($key, $expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->increment($key, $step), $expectedValue);
	}

	public function testDecrement()
	{
		$key = 'key';
		$startValue = 2;
		$expectedValue = 1;

		$this->_counter
			->shouldReceive('get')
			->with($key)
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('set')
			->with($key, $expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->decrement($key), $expectedValue);
	}

	public function testDecrementByStep()
	{
		$key = 'key';
		$startValue = 3;
		$step = 2;
		$expectedValue = 1;

		$this->_counter
			->shouldReceive('get')
			->with($key)
			->andReturn($startValue);

		$this->_counter
			->shouldReceive('set')
			->with($key, $expectedValue)
			->andReturn($expectedValue);

		$this->assertSame($this->_counter->decrement($key, $step), $expectedValue);
	}
}