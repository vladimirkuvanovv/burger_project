<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class DB
 * @package Core
 */
class DB
{
    /**
     * @var
     */
    private static $_instance;

    /**
     * @return DB
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * DB constructor.
     */
    private function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection(
            [

                "driver" => "mysql",
                "host" => env('DB_HOST'),
                "database" => env('DB_NAME'),
                "username" => env('DB_USER'),
                "password" => env('DB_PASS'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ]
        );

        //Make this Capsule instance available globally.
        $capsule->setAsGlobal();
        // Setup the Eloquent ORM.
        $capsule->bootEloquent();
        $capsule->bootEloquent();
    }

    /**
     * Disable clone
     */
    private function __clone() { }
}