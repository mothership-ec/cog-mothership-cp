<?php

namespace Message\Mothership\ControlPanel\Statistic;

/**
 * Interface for dataset ranges.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
interface RangeInterface
{
	/**
	 * Set the name of the owning dataset, to be used a prefix to the key.
	 *
	 * @param  string $datasetName
	 * @return CounterInterface
	 */
	public function setDatasetName($datasetName);

	/**
	 * Get a range of values between the from and to timestamps.
	 *
	 * @param  int      $from
	 * @param  int|null $to   Defaults to the current time.
	 * @return array
	 */
	public function getValues($from, $to = null);

	/**
	 * Get the average of the values between the from and to timestamps.
	 *
	 * @param  int      $from
	 * @param  int|null $to   Defaults to the current time.
	 * @return float
	 */
	public function getAverage($from, $to = null);

	/**
	 * Get the total of the values between the from and to timestamps.
	 *
	 * @param  int      $from
	 * @param  int|null $to   Defaults to the current time.
	 * @return float
	 */
	public function getTotal($from, $to = null);
}