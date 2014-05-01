<?php

namespace Message\Mothership\ControlPanel\Test\Statistic;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Message\Cog\DB\Adapter\Faux\Connection as FauxConnection;
use Message\Mothership\ControlPanel\Statistic\KeyValueDataset;

class KeyValueDatasetTest extends PHPUnit_Framework_TestCase
{
	protected $_query;
	protected $_dataset;

	public function setUp()
	{
		$this->_query = m::mock('Message\Cog\DB\Query[query]', [
			new FauxConnection
		]);

		$this->_dataset = new KeyValueDataset($this->_query);
	}

	public function testAdd()
	{
		$key   = 'test';
		$value = 1;

		$this->_query
			->shouldReceive('run')
			->with('some sql string', [
				'name'      => null,
				'key'       => $key,
				'value'     => $value,
				'createdAt' => null
			]);

		$this->_dataset->add($key, $value);
	}

	public function testGetRange()
	{

	}

	public function testGetAverage()
	{

	}

	public function testGetTotal()
	{

	}
}