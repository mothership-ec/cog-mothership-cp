<?php

namespace Message\Mothership\ControlPanel\Event;

use Message\Cog\HTTP\Request;

/**
 * Event for building a menu.
 *
 * @author Joe Holdcroft <joe@message.co.uk>
 */
class BuildMenuEvent extends Event
{
	protected $_items = array();

	/**
	 * Add an item to the menu.
	 *
	 * The target route is added to the array of route and route collection
	 * names for this item if it is not already in there.
	 *
	 * @param string $targetRoute Name of the route to link to
	 * @param string $label       Label for the menu item
	 * @param array  $routes      Array of route or route collection names that
	 *                            sit within this item
	 * @param array  $classes     Array of classes to apply to the menu item
	 *
	 * @throws \InvalidArgumentException If a route is defined that is already
	 *                                   defined within another menu item
	 */
	public function addItem($targetRoute, $label, array $routes = array(), array $classes = array())
	{
		foreach ($this->_items as $item) {
			$duplicateRoutes = array_intersect($routes, $item['routes']);

			if (count($duplicateRoutes) > 0) {
				throw new \InvalidArgumentException(sprintf(
					'Route(s) `%s` is already defined for menu item "%s"',
					join($duplicateRoutes, ', '),
					$item['label']
				));
			}
		}

		// Add the target route to the array of routes, if not already there
		if (!in_array($targetRoute, $routes)) {
			$routes[] = $targetRoute;
		}

		$this->_items[] = array(
			'target'  => $targetRoute,
			'label'   => $label,
			'routes'  => $routes,
			'classes' => $classes,
		);
	}

	/**
	 * This method checks which item the current request should fall within by
	 * looping through the list of allowed route names and route collection
	 * names for each menu item, and checking if any of these match either the
	 * current route name or any collection the current route is in.
	 * The current item then has $className added to the array of classes for the
	 * menu item.
	 *
	 * @param Message\Cog\HTTP\Request	$request 	Current request
	 * @param string					$className 	Name of the class added to the current item
	 */
	public function setClassOnCurrent(Request $request, $className)
	{
		$currentRoute       = $request->attributes->get('_route');
		$currentCollections = $request->attributes->get('_route_collections');

		foreach ($this->_items as $key => $item) {
			foreach ($item['routes'] as $route) {
				if ($route === $currentRoute
				 || in_array($route, $currentCollections)) {
					$this->_tems[$key]['classes'][] = $className;
					break;
				}
			}
		}
	}

	/**
	 * Get the defined menu items.
	 *
	 * @return array The menu items
	 */
	public function getItems()
	{
		return $this->_items;
	}
}