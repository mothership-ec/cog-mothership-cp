<?php

namespace Message\Mothership\ControlPanel\FieldType;

use Message\Cog\Field\Type\Richtext as BaseRichtext;

class Richtext extends BaseRichtext
{
	public function getFormType()
	{
		return 'wysiwyg';
	}
}