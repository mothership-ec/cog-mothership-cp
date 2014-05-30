<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;

abstract class AbstractCounter implements CounterInterface, TransactionalInterface
{
	protected $_query;
	protected $_transOverriden = false;

	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	public function setTransaction(Transaction $trans)
	{
		$this->_query = $trans;
		$this->_transOverriden = true;
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

		$period = 0;

		if ($periodLength = $this->getPeriodLength()) {
			$currentPeriod = time() - (time() % $periodLength);
			$period = $currentPeriod - ($periodLength * $ago);
		}

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