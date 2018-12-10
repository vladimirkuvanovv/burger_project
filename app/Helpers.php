<?php

namespace App;


use http\Exception;

/**
 * Class Helpers
 * @package App
 */
class Helpers
{
    /**
     * @param $url
     * @param array $params
     * @param int $status
     */
    public static function redirect($url, $params = [], $status = 302)
    {
        return header('Location: //' . $_SERVER['SERVER_NAME'] . '/' . $url . '?' . http_build_query($params), false, $status);
    }

    public static function userIsAuth()
    {
        return !empty($_SESSION['user']) && isset($_SESSION['user']) && isset($_SESSION['user']['id']);
    }
}