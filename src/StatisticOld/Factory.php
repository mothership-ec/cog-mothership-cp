<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\QueryableInterface;

class Factory
{
	const COUNTER     = "CounterDataset";
	const KEY_VALUE   = "KeyValueDataset";
	const KEY_COUNTER = "KeyCounterDataset";

	const HOURLY = 3600;   // 60 * 60
	const DAILY  = 86400;  // 60 * 60 * 24
	const WEEKLY = 604800; // 60 * 60 * 24 * 7

	protected $_query;

	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	public function create($name, $type, $period = null)
	{
		$class = "\Message\Mothership\ControlPanel\Statistic\\" . $type;
		$dataset = new $class($this->_query);

		$dataset->setName($name);

		if ($period and method_exists($dataset, 'setPeriod')) {
			$dataset->setPeriod($period);
		}

		return $dataset;
	}
}