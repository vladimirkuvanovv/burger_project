<?php
/**
 * Created by PhpStorm.
 * User: vladimirkuvanovvgmail.com
 * Date: 30/11/2018
 * Time: 08:09
 */
namespace App;

class Loader {
    protected $routes;
    protected $class;
    public function __construct()
    {
        $this->routes = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function loadFile()
    {

    }
    public function loadClass()
    {
        if (empty($this->routes[1])) {
            $className = 'Main';
        } else {
            $className = ucfirst($this->routes[1]);
        }
        $finalClassName = '\\App\\Controllers\\'.$className;
        $this->class = new $finalClassName;
    }

    public function fireMethod()
    {
        if (empty($this->routes[2])) {
            $method = 'index';
        } else {
            $method = ucfirst($this->routes[2]);
        }
        $this->class->$method();
    }

}