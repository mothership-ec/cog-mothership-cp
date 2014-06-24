<?php

namespace Message\Mothership\ControlPanel\Statistic {

// Overwrite the time() method within the namespace of the class being tested,
// this allows us to return a definite value.
function time() {
	return 179;
}

}

namespace Message\Mothership\ControlPanel\Test\Statistic {

use Mockery as m;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

use Message\Cog\ValueObject\DateTimeImmutable;

class AbstractCounterTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_counter;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\QueryableInterface');

		$this->_counter = new Mocks\FauxCounter($this->_query);
	}

	public function testGetPeriodDefault()
	{
		$expectedPeriod = 120;

		$this->assertSame($this->_counter->getPeriod(), $expectedPeriod);
	}

	public function testGetPeriodInPast()
	{
		$expectedPeriod = 60;

		$this->assertSame($this->_counter->getPeriod(-1), $expectedPeriod);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetPeriodInFutureFails()
	{
		$this->_counter->getPeriod(1);
	}

	public function testSet()
	{
		$expectedValue = 1;

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset'   => 'mock-dataset',
				'key'       => 'mock-dataset.key',
				'period'    => 60,
				'value'     => 1,
				'createdAt' => new DateTimeImmutable,
			])
			->andReturn(null);

		$returnedValue = $this->_counter->set('key', 1, 60);

		$this->assertSame($returnedValue, $expectedValue);
	}

	public function testPush()
	{
		$expectedValue = 1;

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset'   => 'mock-dataset',
				'key'       => 'mock-dataset',
				'period'    => 60,
				'value'     => 1,
				'createdAt' => new DateTimeImmutable,
			])
			->andReturn(null);

		$returnedValue = $this->_counter->push(1, 60);

		$this->assertSame($returnedValue, $expectedValue);
	}

	public function testGetDefault()
	{
		$expectedValue = 1;

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset' => 'mock-dataset',
				'key'     => 'mock-dataset',
				'period'  => new DateTimeImmutable(date('c', 120)),
			])
			->andReturn([
				(object) [
					'value' => $expectedValue,
				]
			]);

		$this->assertSame($this->_counter->get(), $expectedValue);
	}

	public function testGetKey()
	{
		$expectedValue = 1;

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset' => 'mock-dataset',
				'key'     => 'mock-dataset.key',
				'period'  => new DateTimeImmutable(date('c', 120)),
			])
			->andReturn([
				(object) [
					'value' => $expectedValue,
				]
			]);

		$this->assertSame($this->_counter->get('key'), $expectedValue);
	}
}

}