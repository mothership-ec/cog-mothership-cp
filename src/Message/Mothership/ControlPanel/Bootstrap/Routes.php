<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Cog\Bootstrap\RoutesInterface;

class Routes implements RoutesInterface
{
	public function registerRoutes($router)
	{
		$router['ms.cp']->setPrefix('/admin');

		$router['ms.cp']->add('ms.cp.dashboard', '/dashboard', '::Controller:Dashboard#index');

		$router['ms.cp']->add('ms.cp.login', '/login', '::Controller:Authentication#login');
		$router['ms.cp']->add('ms.cp.logout', '/logout', '::Controller:Authentication#logout');

		$router['ms.cp']->add('ms.cp.password.request', '/password/request/{email}', '::Controller:ForgottenPassword#request')
			->setDefault('email', null);
	}
}