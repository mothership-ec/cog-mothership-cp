<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\ControlPanel\Event\Dashboard\DashboardEvent;

class Dashboard extends \Message\Cog\Controller\Controller
{
	public function index()
	{
		$event = $this->get('event.dispatcher')->dispatch(
			DashboardEvent::DASHBOARD_INDEX,
			new DashboardEvent
		);

		return $this->render('::dashboard', [
			'dashboardReferences' => $event->getReferences()
		]);
	}
}