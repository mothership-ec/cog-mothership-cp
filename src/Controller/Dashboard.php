<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\ControlPanel\Event\Dashboard\DashboardIndexEvent;

class Dashboard extends \Message\Cog\Controller\Controller
{
	public function index()
	{
		$event = $this->get('event.dispatcher')->dispatch(
			'dashboard.references',
			new DashboardIndexEvent
		);

		return $this->render('::dashboard', [
			'dashboardReferences' => $event->getReferences()
		]);
	}
}