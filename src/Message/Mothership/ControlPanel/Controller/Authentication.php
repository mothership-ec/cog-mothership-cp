<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\CMS\Page\Page;
use Message\Mothership\CMS\Page\Authorisation;
use Message\Cog\ValueObject\DateRange;

class Authentication extends \Message\Cog\Controller\Controller
{
	public function login()
	{
		return $this->render('::login');
	}

	public function logout()
	{
		#$this->_services['http.session']->remove('user');

		return $this->redirect($this->generateUrl('ms.cp.login'));
	}
}