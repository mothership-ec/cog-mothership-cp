<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\DB\Transaction;
use Message\Cog\DB\QueryableInterface;
use Message\Cog\DB\TransactionalInterface;

/**
 * Abstract counter that implements the counter interface methods with default
 * functionality. Additionally implements the transactional interface to allow
 * the counter to only record values if the surrounding process succeeds.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
abstract class AbstractCounter implements CounterInterface, TransactionalInterface
{
	protected $_query;
	protected $_transOverriden = false;

	protected $_periodLength;

	/**
	 * Constructor.
	 *
	 * @param QueryableInterface $query
	 */
	public function __construct(QueryableInterface $query)
	{
		$this->_query = $query;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setTransaction(Transaction $trans)
	{
		$this->_query = $trans;
		$this->_transOverriden = true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setDatasetName($datasetName)
	{
		$this->_datasetName = $datasetName;

		return $this;
	}

	/**
	 * Get the dataset name.
	 *
	 * @return string
	 */
	public function getDatasetName()
	{
		return $this->_datasetName;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setPeriodLength($periodLength)
	{
		$this->_periodLength = $periodLength;

		return $this;
	}

	/**
	 * Get the length of the period.
	 *
	 * @return int
	 */
	public function getPeriodLength()
	{
		return $this->_periodLength;
	}

	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
	public function set($key, $value, $period = null)
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
			'period'    => ($period) ?: new DateTimeImmutable(date('c', $this->getPeriod())),
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function push($value, $period = null)
	{
		return $this->set('', $value, $period);
	}

	/**
	 * {@inheritDoc}
	 */
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