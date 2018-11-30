<?php
use App\Loader;

require "vendor/autoload.php";

$loader = new Loader();
$loader->loadClass();
$loader->loadFile();
$loader->fireMethod();

//$routes = explode('/', $_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($_SERVER);