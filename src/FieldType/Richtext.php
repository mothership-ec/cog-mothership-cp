<?php

namespace Message\Mothership\ControlPanel\FieldType;

use Message\Cog\Field\Type\Richtext as BaseRichtext;
use Symfony\Component\Form\FormBuilder;


class Richtext extends BaseRichtext
{
	public function getFieldType()
	{
		return 'richtext';
	}

	public function getFormType()
	{
		return 'cp_wysiwyg';
	}

	public function getFormField(FormBuilder $form)
	{
		$form->add($this->getName(), $this->getFormType(), $this->getFieldOptions());
	}
}