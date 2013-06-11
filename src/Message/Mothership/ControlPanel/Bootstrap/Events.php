<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel\Event;
use Message\Mothership\ControlPanel\UserGroup;

use Message\Cog\Bootstrap\EventsInterface;
use Message\Cog\Service\ContainerAwareInterface;
use Message\Cog\Service\ContainerInterface;

class Events implements EventsInterface, ContainerAwareInterface
{
	protected $_services;

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container)
	{
		$this->_services = $container;
	}

	public function registerEvents($dispatcher)
	{
		$dispatcher->addListener(Event\Event::BUILD_MAIN_MENU, function($event) {
			$event->addItem('ms.cp.dashboard', 'Dashboard');
		});

		$dispatcher->addListener('modules.load.success', array($this, 'addGroups'));

		#$dispatcher->addSubscriber(new \Message\Mothership\ControlPanel\EventListener\RegisterAssets);
	}

	public function addGroups()
	{
		$this->_services['user.groups']
			->add(new UserGroup\SuperAdmin)
			->add(new UserGroup\TestGroup);
	}
}