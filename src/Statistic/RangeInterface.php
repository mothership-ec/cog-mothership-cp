<?php

namespace Message\Mothership\ControlPanel\Statistic;

interface RangeInterface
{
	public function getValues($from, $to = null);
	public function getAverage($from, $to = null);
	public function getTotal($from, $to = null);
}