<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Cog\Controller\Controller;

class Markdown extends Controller
{
	public function convert()
	{
		$md = $this->get('request')->get('md');
		$md = $md ? $this->get('markdown.parser')->transform($md) : '';

		return $this->render('Message:Mothership:ControlPanel::markdown:render', [
			'md' => $md,
		]);
	}
}