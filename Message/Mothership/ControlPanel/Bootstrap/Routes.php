<?php

namespace Message\Mothership\ControlPanel\Bootstrap;

use Message\Cog\Bootstrap\RoutesInterface;

class Routes implements RoutesInterface
{
	public function registerRoutes($router)
	{
		$router->add('ms.cp.login', '/login', '::Controller:Authentication#login');
	}
}