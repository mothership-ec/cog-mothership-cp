<?php

namespace Message\Mothership\ControlPanel\Statistic;

interface CounterInterface
{
	public function setDatasetName($datasetName);
	public function setPeriodLength($periodLength);
	public function getPeriod($ago = -1);
	public function set($key, $value, $period = null);
	public function push($value, $period = null);
}