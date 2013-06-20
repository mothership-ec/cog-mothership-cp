<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Cog\Bootstrap\RoutesInterface;

class Routes implements RoutesInterface
{
	public function registerRoutes($router)
	{
		$router['ms.cp']->setPrefix('/admin');
		$router['ms.cp.external']->setPrefix('/admin');

		$router['ms.cp.external']->add('ms.cp.login', '/login', '::Controller:Authentication#login');
		$router['ms.cp.external']->add('ms.cp.logout', '/logout', '::Controller:Authentication#logout');

		$router['ms.cp.external']->add('ms.cp.dashboard', '/', '::Controller:Dashboard#index');

		$router['ms.cp.external']->add('ms.cp.password.request', '/password/request', '::Controller:ForgottenPassword#request');
		$router['ms.cp.external']->add('ms.cp.password.request.email_prefill', '/password/request/{email}', '::Controller:ForgottenPassword#request');
		$router['ms.cp.external']->add('ms.cp.password.reset', '/password/reset/{email}/{hash}', '::Controller:ForgottenPassword#reset');
	}
}