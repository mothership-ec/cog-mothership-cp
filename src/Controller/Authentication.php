<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\User\AnonymousUser;

class Authentication extends \Message\Cog\Controller\Controller
{
	protected $_redirectRoute = 'ms.cp.dashboard';

	public function login()
	{
		if (!($this->get('user.current') instanceof AnonymousUser)) {
			return $this->redirectToRoute($this->_redirectRoute);
		}

		$redirectUrl = ($this->get('http.request.master')->headers->get('referer')
			?: $this->generateUrl($this->_redirectRoute));

		return $this->render('::login', array(
			'redirectUrl' => $redirectUrl,
		));
	}

	public function logout()
	{
		return $this->forward('Message:User::Controller:Authentication#logoutAction', array(
			'redirectURL' => $this->generateUrl('ms.cp.login')
		));
	}
}