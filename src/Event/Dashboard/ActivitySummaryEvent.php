<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use Message\Mothership\ControlPanel\Event\Event;

class ActivitySummaryEvent extends Event
{
	protected $_user;
	protected $_activities;

	public function setUser($user)
	{
		$this->_user = $user;
	}

	public function getUser()
	{
		return $this->_user;
	}

	public function addActivity(Activity $activity)
	{
		$this->_activities[] = $activity;
	}

	public function getActivities()
	{
		return $this->_activities;
	}
}