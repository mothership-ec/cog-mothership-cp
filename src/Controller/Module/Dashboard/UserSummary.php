<?php

namespace Message\Mothership\ControlPanel\Controller\Module\Dashboard;

use Message\Cog\Controller\Controller;
use Message\Mothership\ControlPanel\Event\Dashboard\UserSummaryEvent;

class UserSummary extends Controller implements DashboardModuleInterface
{
	const CACHE_KEY = 'dashboard.module.user-summary.';
	const CACHE_TTL = 60;

	/**
	 *
	 *
	 * @todo   Fire an event which the activities are loaded onto from their
	 *         respective cogules.
	 * @return
	 */
	public function index()
	{
		$user = $this->get('user.current');

		if (false === $data = $this->get('cache')->fetch(self::CACHE_KEY . $user->id)) {
			$event = new UserSummaryEvent;
			$event->setUser($user);
			$this->get('event.dispatcher')->dispatch('dashboard.user-summary.activities', $event);

			/*
			// page
			$pageID = $this->get('db.query')->run("SELECT page_id FROM page WHERE updated_by = :userID?i ORDER BY updated_at DESC LIMIT 1", [
				'userID' => $user->id
			]);
			if (count($pageID)) {
				$page = $this->get('cms.page.loader')->getByID($pageID[0]->page_id);

				$activities[] = [
					'label' => 'Last edited page',
					'date'  => $page->updatedAt,
					'name'  => $page->name,
					'url'   => '',
				];
			}

			// product
			$productID = $this->get('db.query')->run("SELECT product_id FROM product WHERE updated_by = :userID?i ORDER BY updated_at DESC LIMIT 1", [
				'userID' => $user->id
			]);
			if (count($pageID)) {
				$product = $this->get('product.loader')->getByID($productID[0]->product_id);

				$activities[] = [
					'label' => 'Last edited product',
					'date'  => $product->updatedAt,
					'name'  => $product->name,
					'url'   => '',
				];
			}

			// order
			*/

			$data = [
				'activities' => $event->getActivities(),
			];

			$this->get('cache')->store(self::CACHE_KEY . $user->id, $data, self::CACHE_TTL);
		}

		return $this->render('::modules:dashboard:user-summary', [
			'user'       => $user,
			'activities' => $data['activities'],
		]);
	}
}