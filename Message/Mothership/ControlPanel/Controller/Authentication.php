<?php

namespace Message\Mothership\ControlPanel\Controller;

use Symfony\Component\HttpFoundation\Cookie;

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
		// Check we have some post data, otherwsie redirect back to the login page
		if ($post = $this->_services['request']->request->get('login')) {

			// At this stage we need to check the post data is all there
			// Then we need to ensure that there is a username and password actually match
			$session = $this->_services['http.session'];
			$user = $this->_services['user'];
			$data = array(
				'id'		=> 69,
				'forename' 	=> 'Danny',
				'surname'	=> 'Hannah',
				'email'		=> 'danny@message.co.uk',
			);

			if ($post['remember']) {
				
				$cookie = new Cookie('user_id',69);
				var_dump($this->_services['request']->cookies); exit;
			}

			$user->load($data);
			$session->set('user',$user);

			return $this->render('::admin', $data);
		} else {
			// Redirect back
			$this->redirect($this->generateUrl('ms.cp.login'));
		}
	}

	public function logout()
	{
		$session = $this->_services['http.session'];
		$session->remove('user');
		return $this->redirect($this->generateUrl('ms.cp.login'));
	}

}