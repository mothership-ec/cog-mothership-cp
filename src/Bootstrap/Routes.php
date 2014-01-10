<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Cog\Bootstrap\RoutesInterface;

class Routes implements RoutesInterface
{
	public function registerRoutes($router)
	{
		$router['ms.cp']->setPrefix('/admin');
		$router['ms.cp.external']->setPrefix('/admin');

		$router['ms.cp']->add('ms.cp.dashboard', '/', 'Message:Mothership:ControlPanel::Controller:Dashboard#index');

		$router['ms.cp.external']->add('ms.cp.login', '/login', 'Message:Mothership:ControlPanel::Controller:Authentication#login');
		$router['ms.cp.external']->add('ms.cp.logout', '/logout', 'Message:Mothership:ControlPanel::Controller:Authentication#logout');

		$router['ms.cp.external']->add('ms.cp.password.request', '/password/request', 'Message:Mothership:ControlPanel::Controller:ForgottenPassword#request');
		$router['ms.cp.external']->add('ms.cp.password.request.email_prefill', '/password/request/{email}', 'Message:Mothership:ControlPanel::Controller:ForgottenPassword#request');
		$router['ms.cp.external']->add('ms.cp.password.reset', '/password/reset/{email}/{hash}', 'Message:Mothership:ControlPanel::Controller:ForgottenPassword#reset');
	}
}