<?php

namespace Message\Mothership\ControlPanel\Form;

use Symfony\Component\Form\AbstractExtension;

class ControlPanelExtension extends AbstractExtension
{
	protected function loadTypes()
	{
		return [
			new Type\WysiwygType,
		];
	}
}