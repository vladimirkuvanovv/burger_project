<?php
/**
 * Created by PhpStorm.
 * User: vladimirkuvanovvgmail.com
 * Date: 02/12/2018
 * Time: 23:06
 */

namespace App\Controllers;


use App\Helpers;

class AuthController extends BaseController
{
    public function getIndex()
    {
        return $this->view->render('auth');
    }


}