<?php

namespace Message\Mothership\ControlPanel\Statistic;

/**
 * A basic implementation of the counter with increment and decrement methods,
 * ignoring any keys.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
class Counter extends AbstractCounter
{
	/**
	 * Increment the current period's value by the step amount.
	 *
	 * @param  int $step Optional, defaults to 1.
	 * @return Counter
	 */
	public function increment($step = 1)
	{
		$value = $this->get() + $step;

		return $this->push($value);
	}

	/**
	 * Decrement the current period's value by the step amount.
	 *
	 * @param  int $step Optional, defaults to 1.
	 * @return Counter
	 */
	public function decrement($step = 1)
	{
		$value = $this->get() - $step;

		return $this->push($value);
	}
}