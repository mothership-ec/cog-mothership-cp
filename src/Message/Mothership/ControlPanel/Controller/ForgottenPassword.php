<?php

namespace Message\Mothership\ControlPanel\Controller;

class ForgottenPassword extends \Message\Cog\Controller\Controller
{
	public function request($email = null)
	{
		return $this->render('Message:Mothership:ControlPanel::password/request', array(
			'email' => $email,
		));
	}

	public function reset($email, $hash)
	{
		$user = $this->get('user.loader')->getByEmail($email);

		return $this->render('::password/reset', array(
			'email' => $email,
			'hash'  => $hash,
			'user'  => $user,
		));
	}
}