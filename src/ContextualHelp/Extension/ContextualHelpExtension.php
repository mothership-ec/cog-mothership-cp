<?php

namespace Message\Mothership\ControlPanel\ContextualHelp\Extension;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Validator\ValidatorInterface;
use Message\Cog\HTTP\Session;

/**
 * Extension adding Type\ValidationMessageTypeExtension
 *
 * @author Iris Schaffer <iris@message.co.uk>
 */
class ContextualHelpExtension extends AbstractExtension
{
	protected function loadTypeExtensions()
	{
		return array(
			new Type\ContextualHelpTypeExtension,
		);
	}
}
