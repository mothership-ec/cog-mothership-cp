<?php

namespace Message\Mothership\ControlPanel\UserGroup;

use Message\User\Group;

class SuperAdmin implements Group\GroupInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'ms-super-admin';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName()
	{
		return 'Mothership Super Administrators';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'Users with access to everything in the Mothership Control Panel.';
	}

	/**
	 * {@inheritdoc}
	 */
	public function registerPermissions(Group\Permissions $permissions)
	{
		$permissions
			->addRouteCollection('ms.cp');
	}
}