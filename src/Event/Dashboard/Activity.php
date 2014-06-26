<?php

namespace Message\Mothership\ControlPanel\Event\Dashboard;

use DateTime;

class Activity
{
	public $label;
	public $date;
	public $name;
	public $url;

	public function __construct($label, DateTime $date, $name, $url)
	{
		$this->label = $label;
		$this->date  = $date;
		$this->name  = $name;
		$this->url   = $url;
	}
}