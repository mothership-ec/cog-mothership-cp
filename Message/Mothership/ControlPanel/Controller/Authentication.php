<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\CMS\Page\Page;
use Message\Mothership\CMS\Page\Authorisation;
use Message\Cog\ValueObject\DateRange;

class Authentication extends \Message\Cog\Controller\Controller
{
	public function login()
	{
		$session = $this->_services['http.session'];
		$user    = $session->get('user');

		return $this->render('::login', array(
			'user'   => $user,
			'logout' => false,
		));
	}

	public function loginAction()
	{
		// Check we have some post data, otherwsie redirect back to the login page
		if ($post = $this->_services['request']->request->get('login')) {

			// At this stage we need to check the post data is all there
			// Then we need to ensure that there is a username and password actually match
			$user = $this->_services['user'];
			$user->id       = 69;
			$user->forename = 'Danny';
			$user->surname  = 'Hannah';
			$user->email    = 'danny@message.co.uk';

			if (isset($post['remember']) && $post['remember']) {
				$this->_services['http.cookies']->add(
					new \Message\Cog\HTTP\Cookie('user_id', $user->id)
				);
			}

			$this->_services['http.session']->set('user', $user);

			return $this->render('::admin', $data);
		}

		return $this->redirect($this->generateUrl('ms.cp.login'));
	}

	public function logout()
	{
		$this->_services['http.session']->remove('user');

		return $this->redirect($this->generateUrl('ms.cp.login'));
	}
}