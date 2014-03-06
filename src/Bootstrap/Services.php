<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Mothership\ControlPanel;

use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		$services->extend('form.templates.twig', function($templates, $c) {
			$templates[] = 'Message:Mothership:ControlPanel::form:twig:form_div_layout';

			return $templates;
		});

		$services->extend('form.templates.php', function($templates, $c) {
			$templates[] = '::form:twig:php';

			return $templates;
		});

		$services->extend('user.groups', function($groups) {
			$groups->add(new ControlPanel\UserGroup\SuperAdmin);

			return $groups;
		});
	}
}