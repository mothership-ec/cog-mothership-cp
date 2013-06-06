<?php

namespace Message\Mothership\ControlPanel\Controller;

class Dashboard extends \Message\Cog\Controller\Controller
{
	public function index()
	{
		return $this->render('::dashboard', array(
			'user' => $this->get('user.current'),
		));
	}
}