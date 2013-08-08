<?php

namespace Message\Mothership\ControlPanel\Controller;

use Message\Mothership\ControlPanel\Event\Event;
use Message\Mothership\ControlPanel\Event\BuildMenuEvent;

/**
 * Controllers for the control panel menus.
 *
 * @author Joe Holdcroft <joe@message.co.uk>
 */
class Menu extends \Message\Cog\Controller\Controller
{
	/**
	 * Render the main menu.
	 *
	 * This fires the event defined as `Event::BUILD_MAIN_MENU` of type
	 * `BuildMenuEvent`. This event allows listeners to add items to the main
	 * menu.
	 *
	 * It then checks which item the current request should fall within by
	 * looping through the list of allowed route names and route collection
	 * names for each menu item, and checking if any of these match either the
	 * current route name or any collection the current route is in.
	 * The current item then has "current" added to the array of classes for the
	 * menu item.
	 *
	 * @return \Message\Cog\HTTP\Response
	 */
	public function main()
	{
		$event = new BuildMenuEvent;

		$this->get('event.dispatcher')->dispatch(
			Event::BUILD_MAIN_MENU,
			$event
		);

		$event->setClassOnCurrent($this->get('http.request.master'), 'current');

		return $this->render('Message:Mothership:ControlPanel::main_menu', array(
			'items' => $event->getItems(),
		));
	}
}