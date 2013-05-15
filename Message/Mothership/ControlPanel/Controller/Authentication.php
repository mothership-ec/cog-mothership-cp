<?php

namespace Message\Mothership\ControlPanel\Controller;

class Authentication extends \Message\Cog\Controller\Controller
{	
	public function login()
	{
		$session = $this->_services['http.session'];
		$user = $session->get('user');
		$return = array(
			'user' => $user,
			'logout' => false,
		);

		return $this->render('::login', $return);
	}
	
	public function loginAction()
	{
		$session = $this->_services['http.session'];
		$user = $this->_services['user'];
		$data = array(
			'id'		=> 69,
			'forename' 	=> 'Danny',
			'surname'	=> 'Hannah',
			'email'		=> 'danny@message.co.uk',
		);

		$user->load($data);
		$session->set('user',$user);
		
		return $this->render('::admin', $data);
	}

	public function logout()
	{
		$session = $this->_services['http.session'];
		$session->remove('user');
		return $this->redirect($this->generateUrl('ms.cp.login'));
	}

}