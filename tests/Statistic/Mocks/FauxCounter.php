<?php

namespace Message\Mothership\ControlPanel\Test\Statistic\Mocks;

use Message\Mothership\ControlPanel\Statistic\AbstractCounter;

class FauxCounter extends AbstractCounter
{
	public function getDatasetName()
	{
		return 'mock-dataset';
	}

	public function getPeriodLength()
	{
		return 60;
	}
}