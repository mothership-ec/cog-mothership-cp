<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use Message\Cog\Event\Event;

class UserSummaryEvent extends Event
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

	public function addActivity($activity)
	{
		$this->_activities[] = $activity;
	}

	public function getActivities()
	{
		return $this->_activities;
	}
}