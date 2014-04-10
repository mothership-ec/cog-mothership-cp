<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use Message\Mothership\ControlPanel\Event\Event;

class DashboardEvent extends Event
{
	protected $_references;

	public function addReference($reference)
	{
		$this->_references[] = $reference;
	}

	public function getReferences()
	{
		return $this->_references;
	}
}