<?php

namespace Message\Mothership\ControlPanel\Statistic;

use Message\Cog\ValueObject\DateTimeImmutable;

class KeyValueDataset extends Dataset
{
	public function add($key, $value)
	{
		$this->_query->run("
			INSERT INTO statistics (
				`dataset`,
				`key`,
				`value`,
				`created_at`
			)
			VALUES (
				:dataset?s,
				:key?s,
				:value?f,
				:createdAt?d
			)
			ON DUPLICATE KEY UPDATE
				`value` = (`value` + VALUES(`value`)),
				`created_at` = VALUES(`created_at`)
		", [
			'dataset'   => $this->_name,
			'key'       => $key,
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);
	}
}