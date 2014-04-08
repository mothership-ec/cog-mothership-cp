<?php

namespace Message\Mothership\ControlPanel\Controller\Module\Dashboard;

use Message\Cog\Controller\Controller;

class CMSSummary extends Controller implements DashboardModuleInterface
{
	const CACHE_KEY = 'dashboard.module.cms-summary';
	const CACHE_TTL = 3600;

	/**
	 *
	 * @todo Add recently deleted
	 *
	 * @return
	 */
	public function index()
	{
		if (false === $data = $this->get('cache')->fetch(self::CACHE_KEY)) {
			$updated = $deleted = [];

			$pages = $this->get('db.query')->run("SELECT page_id, title, updated_at FROM page ORDER BY updated_at DESC LIMIT 5");
			$products = $this->get('db.query')->run("SELECT product_id, name as title, updated_at FROM product ORDER BY updated_at DESC LIMIT 5");

			foreach ($pages as $page) $updated[] = $page;
			foreach ($products as $product) $updated[] = $product;

			usort($updated, function($a, $b) {
				if ($a->updated_at == $b->updated_at) return 0;
				return $a->updated_at < $b->updated_at;
			});

			$updated = array_slice($updated, 0, 4);

			$data = [
				'updated' => $updated
			];

			$this->get('cache')->store(self::CACHE_KEY, $data, self::CACHE_TTL);
		}

		return $this->render('::modules:dashboard:cms-summary', $data);
	}
}