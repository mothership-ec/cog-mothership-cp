<?php

use Message\Cog\Migration\Adapter\MySQL\Migration;

class _1398953239_CreateStatisticTable extends Migration
{
	public function up()
	{
		$this->run("
			CREATE TABLE `statistic` (
			  `dataset`    varchar(255) NOT NULL,
			  `key`        varchar(255) NOT NULL,
			  `period`     int(11) unsigned NOT NULL,
			  `value`      decimal(10,2) NOT NULL,
			  `created_at` int(11) unsigned NOT NULL,
			  PRIMARY KEY (`dataset`, `key`, `period`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}

	public function down()
	{
		$this->run("DROP TABLE `statistic`");
	}
}