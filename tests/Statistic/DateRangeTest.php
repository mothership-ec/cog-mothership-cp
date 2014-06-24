<?php

namespace Message\Mothership\ControlPanel\Test\Statistic;

use Mockery as m;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

use Message\Cog\ValueObject\DateTimeImmutable;

use Message\Mothership\ControlPanel\Statistic\DateRange;

class DateRangeTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_range;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\QueryableInterface');

		$this->_range = (new DateRange($this->_query))
			->setDatasetName('mock-dataset');
	}

	public function testGetValuesFrom()
	{
		$expectedValues = [
			120 => 1.0,
		];

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset' => 'mock-dataset',
				'from'    => new DateTimeImmutable(date('c', 120)),
				'to'      => new DateTimeImmutable(date('c', 179)),
			])
			->andReturn([
				(object) [
					'value' => 1,
					'period' => 120,
				]
			]);

		$returnedValues = $this->_range->getValues(120);

		$this->assertSame($returnedValues, $expectedValues);
	}

	public function testGetValuesFromTo()
	{
		$expectedValues = [
			60 => 1.0,
		];

		$this->_query
			->shouldReceive('run')
			->with(m::any(), [
				'dataset' => 'mock-dataset',
				'from'    => new DateTimeImmutable(date('c', 60)),
				'to'      => new DateTimeImmutable(date('c', 120)),
			])
			->andReturn([
				(object) [
					'value' => 1,
					'period' => 60,
				]
			]);

		$returnedValues = $this->_range->getValues(60, 120);

		$this->assertSame($returnedValues, $expectedValues);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetValuesFromAfterTo()
	{
		$this->_range->getValues(120, 60);
	}
}