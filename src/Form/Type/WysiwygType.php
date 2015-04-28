<?php

namespace Message\Mothership\ControlPanel\Form\Type;

use Symfony\Component\Form;
use Symfony\Component\OptionsResolver;

class WysiwygType extends Form\AbstractType
{
	public function getName()
	{
		return 'cp_wysiwyg';
	}

	public function getParent()
	{
		return 'textarea';
	}
}