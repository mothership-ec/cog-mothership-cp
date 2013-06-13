<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel;

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
		$dispatcher->addListener(ControlPanel\Event\Event::BUILD_MAIN_MENU, function($event) {
			$event->addItem('ms.cp.dashboard', 'Dashboard');
		});

		$dispatcher->addListener('modules.load.success', array($this, 'addGroups'));

		$dispatcher->addSubscriber(new ControlPanel\EventListener);
	}

	public function addGroups()
	{
		$this->_services['user.groups']
			->add(new ControlPanel\UserGroup\SuperAdmin)
			->add(new ControlPanel\UserGroup\TestGroup);
	}
}