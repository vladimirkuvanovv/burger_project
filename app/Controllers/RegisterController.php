<?php
/**
 * Created by PhpStorm.
 * User: vladimirkuvanovvgmail.com
 * Date: 06/12/2018
 * Time: 09:04
 */

namespace App\Controllers;


class RegisterController extends BaseController
{
    public function getIndex()
    {
        return $this->view->render('register');
    }
}