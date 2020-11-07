<?php 

use Illuminate\Database\Capsule\Manager as Connection;

class Database
{
	public function __construct()
	{
		$_connection = new Connection;

		$_connection->addConnection(
			[
				'driver' => 'mysql',
				'host' => '127.0.0.1',
				'database' => 'online_shop',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix' => '',
			]
		);

		$_connection->bootEloquent();
	}
}
