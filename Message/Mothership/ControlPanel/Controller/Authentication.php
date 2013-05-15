<?php

namespace Message\Mothership\ControlPanel\Controller;

class Authentication extends \Message\Cog\Controller\Controller
{

	public function login()
	{
		$return = array(
			'buttonText' => 'I am a button',
		);

		return $this->render('::login', $return);
	}
	
	public function loginAction()
	{
		$user = $this->_services['user'];

		$data = array(
			'forename' 	=> 'Danny',
			'surname'	=> 'Hannah',
			'email'		=> 'danny@message.co.uk',
		);

		$user->load($data);
		var_dump($user); exit;
	}

	public function logout()
	{

	}

}