<?php

namespace Message\Mothership\ControlPanel\Controller;

class ForgottenPassword extends \Message\Cog\Controller\Controller
{
	public function request($email = null)
	{
		return $this->render('::password/request', array(
			'email' => $email,
		));
	}

	public function logout()
	{
		// @todo
		#$this->_services['http.session']->remove('user');

		return $this->redirect($this->generateUrl('ms.cp.login'));
	}
}