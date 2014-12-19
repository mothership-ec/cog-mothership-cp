<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use Message\Mothership\ControlPanel\Event\Event;

class DashboardEvent extends Event
{
	protected $_references;

	public function addReference($reference, $params = [])
	{
		$this->_references[] = [
			'reference' => $reference,
			'params'    => $params,
		];
	}

	public function getReferences()
	{
		return $this->_references;
	}
}