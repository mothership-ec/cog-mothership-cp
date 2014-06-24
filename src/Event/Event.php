<?php

namespace Message\Mothership\ControlPanel\Event;

class Event extends \Message\Cog\Event\Event
{
	const BUILD_MAIN_MENU = 'ms.cp.main_menu.build';
	const DASHBOARD_INDEX = 'dashboard.index';
	const DASHBOARD_ACTIVITY_SUMMARY = 'dashboard.activity.summary';
}