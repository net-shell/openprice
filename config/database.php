<?php

return [

	'fetch' => PDO::FETCH_CLASS,

	'default' => 'neo4j',

	'connections' => [

		'neo4j' => [
			'driver'   => 'neo4j',
			'host'   => 'localhost',
			'port'   => '7474',
			'username' => env(DB_USERNAME, null),
			'password' => env(DB_PASSWORD, null)
		],

	],

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => [

		'cluster' => false,

		'default' => [
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		],

	],

];
