<?php

namespace Message\Mothership\ControlPanel\UserGroup;

use Message\User\Group;

class TestGroup implements Group\GroupInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'ms-test';
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
			->addRoute('ms.cp.file_manager.detail', array('fileID' => 109));
	}
}