<?php

namespace Message\Mothership\ControlPanel\Controller;

class Authentication extends \Message\Cog\Controller\Controller
{

	public function login()
	{
/*
		$return = array(
			"thingy" => "yo",
		);
*/

		return $this->render('::login');
	}

	public function logout()
	{

	}

}