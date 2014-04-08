<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use Message\Cog\Event\Event;

class DashboardIndexEvent extends Event
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