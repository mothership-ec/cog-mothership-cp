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
	 * checking which item has the current route's name defined in the array
	 * of routes for the item. The current item then has "current" added to the
	 * array of classes for the menu item.
	 *
	 * @return \Message\Cog\HTTP\Response
	 */
	public function main()
	{
		$currentRoute = $this->get('http.request.master')->attributes->get('_route');
		$event        = new BuildMenuEvent;

		$this->get('event.dispatcher')->dispatch(
			Event::BUILD_MAIN_MENU,
			$event
		);

		$items = $event->getItems();

		foreach ($items as $key => $item) {
			if (in_array($currentRoute, $item['routes'])) {
				$items[$key]['classes'][] = 'current';
			}
		}

		return $this->render('::main_menu', array(
			'items' => $items,
		));
	}
}