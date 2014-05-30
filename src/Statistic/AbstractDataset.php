<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;

abstract class AbstractDataset implements TransactionalInterface
{
	const HOURLY  = 3600; // 60 * 60;
	const DAILY   = 86400; // 60 * 60 * 24;
	const WEEKLY  = 604800; // 60 * 60 * 24 * 7;
	const MONTHLY = 2592000; // 60 * 60 * 24 * 30;
	const YEARLY  = 31536000; // 60 * 60 * 24 * 365;

	public $counter;
	public $range;

	protected $_query;
	protected $_transOverriden;

	public function __construct(QueryableInterface $query, CounterInterface $counter, RangeInterface $range)
	{
		$this->_query = $query;

		$counter->setDatasetName($this->getName());
		$counter->setPeriodLength($this->getPeriodLength());

		$range->setDatasetName($this->getName());

		$this->counter = $counter;
		$this->range   = $range;
	}

	public function setTransaction(Transaction $trans)
	{
		$this->counter->setTransaction($trans);
		$this->range->setTransaction($trans);

		$this->_query = $trans;
		$this->_transOverriden = true;
	}

	abstract public function getName();
	abstract public function getPeriodLength();
	abstract public function rebuild();
}