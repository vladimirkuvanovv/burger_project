<?php

use App\Router;

session_start();

require "vendor/autoload.php"; // подключает все библиотеки , установленные через composer
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$dotenv = new Dotenv\Dotenv(__DIR__, '.env');
$dotenv->load();


//Boot Database Connection
App\DB::getInstance();


(new Router())->init();
