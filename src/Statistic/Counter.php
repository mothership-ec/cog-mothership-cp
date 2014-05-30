<?php

namespace Message\Mothership\ControlPanel\Statistic;

class Counter extends AbstractCounter
{
	public function increment($step = 1)
	{
		$value = $this->get() + $step;

		return $this->push($value);
	}

	public function decrement($step = 1)
	{
		$value = $this->get() - $step;

		return $this->push($value);
	}
}