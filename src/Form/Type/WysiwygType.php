<?php

namespace Message\Mothership\ControlPanel\Form\Type;

use Symfony\Component\Form;
use Symfony\Component\OptionsResolver;

/**
 * Class WysiwygType
 * @package Message\Mothership\ControlPanel\Form\Type
 *
 * @author  Thomas Marchant <thomas@mothership.ec>
 *
 * Class representing a WYSIWYG editor as a form field. The WYSIWYG editor uses the Medium Editor
 * (https://github.com/daviferreira/medium-editor) with the markdown extension
 * (https://github.com/IonicaBizau/medium-editor-markdown)
 */
class WysiwygType extends Form\AbstractType
{
	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'cp_wysiwyg';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getParent()
	{
		return 'textarea';
	}
}