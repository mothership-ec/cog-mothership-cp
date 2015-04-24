<?php

namespace Message\Mothership\ControlPanel\Form\Type;

use Symfony\Component\Form;
use Symfony\Component\OptionsResolver;

class WysiwygType extends Form\AbstractType
{
	public function getName()
	{
		return 'wysiwyg';
	}

	public function getParent()
	{
		return 'textarea';
	}

	public function setDefaultOptions(OptionsResolver\OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([
			'preview_prefix' => 'md_preview'
		]);
	}
}