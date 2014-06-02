<?php

namespace Message\Mothership\ControlPanel\Statistic;

/**
 * Interface for dataset counters.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
interface CounterInterface
{
	/**
	 * Set the name of the owning dataset, to be used a prefix to the key.
	 *
	 * @param  string $datasetName
	 * @return CounterInterface
	 */
	public function setDatasetName($datasetName);

	/**
	 * Set the length of the period in seconds.
	 *
	 * @param  int $periodLength Length in seconds.
	 * @return CounterInterface
	 */
	public function setPeriodLength($periodLength);

	/**
	 * Get the start of the period a number of times ago. Defaults to the
	 * current period, passing a negative integer returns the start of the
	 * period that many times ago.
	 *
	 * @param  int $ago
	 * @return int Start timestamp of the current period
	 */
	public function getPeriod($ago = 0);

	/**
	 * Set a counter value based on a key and optionally a custom period.
	 *
	 * @param  string   $key    Will be prefixed by the dataset name.
	 * @param  number   $value  Integers will be converted to float.
	 * @param  int|null $period Defaults to the current period.
	 * @return CounterInterface
	 */
	public function set($key, $value, $period = null);

	/**
	 * Push a value to the counter without a key and optionally a custom period.
	 *
	 * @param  number   $value  Integers will be converted to float.
	 * @param  int|null $period Defaults to the current period.
	 * @return CounterInterface
	 */
	public function push($value, $period = null);

	/**
	 * Get the value for the current period, optionally by key.
	 *
	 * @param  string|null $key
	 * @return float
	 */
	public function get($key = null);
}