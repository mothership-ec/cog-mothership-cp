<?php

namespace Message\Mothership\ControlPanel\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

class Error extends \Message\Cog\Controller\Controller
{
	public function exception($exception)
	{
		$errorCode = 500;

		if ($exception instanceof HttpException) {
			$errorCode = $exception->getStatusCode();
		}

		// Change any error codes that aren't 500, 404 or 403 to 500
		if (!in_array($errorCode, array(500, 404, 403))) {
			$errorCode = 500;
		}

		return $this->render('::error/' . $errorCode, array(
			'exception' => $exception,
		));
	}
}