<?php

use Message\Cog\Migration\Adapter\MySQL\Migration;

class _1398953239_CreateStatisticsTable extends Migration
{
	public function up()
	{
		$this->run("
			CREATE TABLE `statistics` (
			  `dataset`    varchar(255) NOT NULL,
			  `key`        varchar(255) NOT NULL,
			  `value`      decimal(10,2) NOT NULL,
			  `created_at` int(11) DEFAULT NULL,
			  PRIMARY KEY (`dataset`, `key`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}

	public function down()
	{
		$this->run("
			DROP TABLE `statistics`
		");
	}
}