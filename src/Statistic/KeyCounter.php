<?php

namespace Message\Mothership\ControlPanel\Statistic;

/**
 * A basic implementation of the counter with increment and decrement methods,
 * with keys.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
class KeyCounter extends AbstractCounter
{
	/**
	 * Increment the current period's value for the key by the step amount.
	 *
	 * @param  string $key
	 * @param  int    $step Optional, defaults to 1.
	 * @return Counter
	 */
	public function increment($key, $step = 1)
	{
		$value = $this->get($key) + $step;

		return $this->set($key, $value);
	}

	/**
	 * Decrement the current period's value for the key by the step amount.
	 *
	 * @param  string $key
	 * @param  int    $step Optional, defaults to 1.
	 * @return Counter
	 */
	public function decrement($key, $step = 1)
	{
		$value = $this->get($key) - $step;

		return $this->set($key, $value);
	}
}