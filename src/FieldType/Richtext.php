<?php

namespace Message\Mothership\ControlPanel\FieldType;

use Message\Cog\Field\Type\Richtext as BaseRichtext;
use Symfony\Component\Form\FormBuilder;

/**
 * Class Richtext
 * @package Message\Mothership\ControlPanel\FieldType
 *
 * @author  Thomas Marchant <thomas@mothership.ec>
 *
 * Class that overrides Cog's Richtext field and replaces it with a WYSIWYG editor
 */
class Richtext extends BaseRichtext
{
	/**
	 * {@inheritDoc}
	 */
	public function getFieldType()
	{
		return 'richtext';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType()
	{
		return 'cp_wysiwyg';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormField(FormBuilder $form)
	{
		$form->add($this->getName(), $this->getFormType(), $this->getFieldOptions());
	}
}