<?php

namespace Message\Mothership\ControlPanel\Form;

use Symfony\Component\Form\AbstractExtension;

/**
 * Class ControlPanelExtension
 * @package Message\Mothership\ControlPanel\Form
 *
 * @author  Thomas Marchant <thomas@mothership.ec>
 */
class ControlPanelExtension extends AbstractExtension
{
	/**
	 * {@inheritDoc}
	 */
	protected function loadTypes()
	{
		return [
			new Type\WysiwygType,
		];
	}
}