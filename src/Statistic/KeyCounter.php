<?php

namespace Message\Mothership\ControlPanel\Statistic;

class KeyCounter extends AbstractCounter
{
	public function increment($key, $step = 1)
	{
		$value = $this->get($key) + $step;

		return $this->push($value);
	}

	public function decrement($key, $step = 1)
	{
		$value = $this->get($key) - $step;

		return $this->push($value);
	}
}