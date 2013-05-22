<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\CMS\Page\Page;
use Message\Mothership\CMS\Page\Authorisation;
use Message\Cog\ValueObject\DateRange;

class Authentication extends \Message\Cog\Controller\Controller
{	
	public function login()
	{
		$page = new Page;
		$page->id = 1;
		$page->password = 'hello';
		$page->publishState = 1;
		$from = new \DateTime('+1 week');
		$to = new \DateTime('+1 week');
		$page->publishDateRange = new DateRange($from, $to);
		
		$user = array();

		$authorisation = new Authorisation($page,$user);
		$password = 'hello';
		
		$authorisation->validatePassword($password);
		var_dump($authorisation->isPublished()); exit;
		var_dump($authorisation); exit;
	
	
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

			if (isset($post['remember']) && $post['remember']) {
				
				$cookie = new \Message\Cog\HTTP\Cookie('user_id',69);				
				$this->_services['http.cookies']->add($cookie);

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