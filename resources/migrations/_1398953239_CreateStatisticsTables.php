<?php

use Message\Cog\Migration\Adapter\MySQL\Migration;

class _1398953239_CreateStatisticsTables extends Migration
{
	public function up()
	{
		$this->run("
			CREATE TABLE `statistic_counter` (
			  `dataset`    varchar(255) NOT NULL,
			  `period`     int(11) NOT NULL,
			  `value`      decimal(10,2) NOT NULL,
			  `created_at` int(11) DEFAULT NULL,
			  PRIMARY KEY (`dataset`, `period`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");

		$this->run("
			CREATE TABLE `statistic_key_value` (
			  `dataset`    varchar(255) NOT NULL,
			  `key`        varchar(255) NOT NULL,
			  `value`      decimal(10,2) NOT NULL,
			  `created_at` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");

		$this->run("
			CREATE TABLE `statistic_key_counter` (
			  `dataset`    varchar(255) NOT NULL,
			  `key`        varchar(255) NOT NULL,
			  `period`     int(11) NOT NULL,
			  `value`      decimal(10,2) NOT NULL,
			  `created_at` int(11) DEFAULT NULL,
			  PRIMARY KEY (`dataset`, `key`, `period`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
	}

	public function down()
	{
		$this->run("DROP TABLE `statistic_counter`");
		$this->run("DROP TABLE `statistic_key_value`");
		$this->run("DROP TABLE `statistic_key_counter`");
	}
}