<?php

namespace App\Controllers;

use App\View;
use Illuminate\Support\Facades\Request;
use Intervention\Image\ImageManager;
use App\Helpers;

/**
 * Class BaseController
 * @package App\Controllers
 */
class BaseController
{
    protected $fileManager;
    protected $view;
    protected $request;
    protected $errors = [];
    protected $dirUpload;
    protected $auth = false;

    public function __construct()
    {
        $this->fileManager = new ImageManager();
        $this->view = new View();
        $this->request = array_merge($_REQUEST, ['files' => $_FILES]);
        $this->errors = $this->scanErrors();
        $this->dirUpload = __DIR__ . '/../../Uploads';

        $this->checkAuth();

    }

    private function checkAuth()
    {
        if (!Helpers::userIsAuth() && $this->auth === true) {  //если не авторизоавн
            return Helpers::redirect('auth/index');
        }

    }

    private function scanErrors()
    {
//        $getErrors = htmlspecialchars_decode($_REQUEST['error_message']);
        if (!empty($getErrors)) {
            return explode('::', $getErrors);
        }
    }


    public function get404()
    {
        return $this->view->render('404', ['title' => '404', 'errors' => ['404 Страница не найдена']]);

    }
}