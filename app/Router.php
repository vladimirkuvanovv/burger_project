<?php

namespace App;


class Router
{
    protected $routes;
    protected $class;
    protected $requestMethod;

    public function __construct()
    {
        $this->requestMethod = mb_strtolower($_SERVER['REQUEST_METHOD']);
        $this->routes = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
    }

    public final function init()
    {
        try {
            $this->loadClass()->fireMethod();
        } catch (\Exception $exception) {
            if ($exception->getCode() === 404) {
                exit(Helpers::redirect('base/404'));
            } else {
                exit($exception->getMessage());
            }

        }
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function loadClass()
    {
        if (empty($this->routes[1])) {
            $className = 'Auth';
        } else {
            $className = ucfirst($this->routes[1]);
        }
        $finalClassName = '\\App\\Controllers\\' . $className . 'Controller';


        if (class_exists($finalClassName)) {
            $this->class = new $finalClassName;
        } else {
            throw new \Exception("404 Error (Not found Class)", 404);
        }
        return $this;


    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function fireMethod()
    {
        if (empty($this->routes[1])) {
            $method = 'getIndex';
        } else {
            $method = $this->requestMethod . $this->routes[2];
        }

        if (method_exists($this->class, $method)) {
            return $this->class->$method();
        } else {
            throw new \Exception("404 Error (Not found method in class " . get_class($this->class) . ")", 404);
        }

    }
}
