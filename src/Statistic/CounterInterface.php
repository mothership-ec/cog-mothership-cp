<?php

namespace Message\Mothership\ControlPanel\Statistic;

interface CounterInterface
{
	public function setDatasetName($datasetName);
	public function setPeriodLength($length);
	public function getPeriod($ago = -1);
	public function set($key, $value);
	public function push($value);
}