<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		$services['form.templates.twig'] = $services->extend('form.templates.twig', function($templates, $c) {
			$templates[] = 'Message:Mothership:ControlPanel::form:twig:form_div_layout';

			return $templates;
		});

		$services['form.templates.php'] = $services->extend('form.templates.php', function($templates, $c) {
			$templates[] = '::form:twig:php';

			return $templates;
		});
	}
}