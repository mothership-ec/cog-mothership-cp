<?php

namespace Message\Mothership\ControlPanel\Event;

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
	 * The target route is added to the array of routes for this item if it is
	 * not already in there.
	 *
	 * @param string $targetRoute Name of the route to link to
	 * @param string $label       Label for the menu item
	 * @param array  $routes      Array of routes that sit within this item
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
	 * Get the defined menu items.
	 *
	 * @return array The menu items
	 */
	public function getItems()
	{
		return $this->_items;
	}
}