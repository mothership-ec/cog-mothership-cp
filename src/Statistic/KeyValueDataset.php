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
				`createdAt`
			)
			VALUES (
				:dataset?s,
				:key?s,
				:value?f,
				:createdAt?d
			)
		", [
			'dataset'   => $this->_name,
			'key'       => $key,
			'value'     => $value,
			'createdAt' => new DateTimeImmutable
		]);
	}
}