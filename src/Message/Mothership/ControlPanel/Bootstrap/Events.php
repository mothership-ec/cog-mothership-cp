<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel\Event\Event;

use Message\Cog\Bootstrap\EventsInterface;

class Events implements EventsInterface
{
	public function registerEvents($dispatcher)
	{
		$dispatcher->addListener(Event::BUILD_MAIN_MENU, function($event) {
			$event->addItem('ms.cp.dashboard', 'Dashboard');
		});
	}
}