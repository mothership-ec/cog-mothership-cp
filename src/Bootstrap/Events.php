<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel;

use Message\Cog\Bootstrap\EventsInterface;

class Events implements EventsInterface
{
	public function registerEvents($dispatcher)
	{
		$dispatcher->addSubscriber(new ControlPanel\EventListener);
	}
}