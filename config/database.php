<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

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
        'client' => 'predis',
        
        'default' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 0,
        ],
        'queue' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 1,
        ],
        'index' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 2,
        ],
        'session' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 3,
        ],
        'broadcast' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 4,
        ],
        'cache' => [
            'scheme' => 'unix',
            'path' => env('REDIS_SOCK', '/tmp/redis.sock'),
            'password' => env('REDIS_PASSWORD', null),
            'database' => 5,
        ],
    ],

    // Redis独自保存アクセスキー
    'keys' => [
        'post-views' => 'kbs3-post-views',
        'post-nices' => 'kbs3-post-nices',
        'post-bads' => 'kbs3-post-bads',
        'post-index-prefix' => 'kbs3-text-index-',
        'post-index-table' => 'kbs3-text-table',
        'post-index-refreshed_at' => 'kbs3-post-refreshed_at',
    ],

];
