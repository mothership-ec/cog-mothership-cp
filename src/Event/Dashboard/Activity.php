<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

class Activity
{
	public $label;
	public $date;
	public $name;
	public $url;

	public function __construct($label, $date, $name, $url)
	{
		$this->label = $label;
		$this->date  = $date;
		$this->name  = $name;
		$this->url   = $url;
	}
}