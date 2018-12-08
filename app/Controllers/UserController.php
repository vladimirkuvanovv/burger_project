<?php

namespace App\Controllers;


use App\Helpers;
use App\Models\File;
use App\Models\User;
use Intervention\Image\ImageManagerStatic as IImage;

class UserController extends BaseController
{
    public $auth = true;

    public function getIndex() //render всех пользователей
    {
//        $users = User::with('avatar')->orderBy('age');
        if (!empty($this->request['sort_name']) && !empty($this->request['sort_by'])) {
//            dd($this->request);
            $user = User::with('avatar')->orderBy($this->request['sort_name'], $this->request['sort_by']);
//                $users->orderBy($this->request['sort_name'], $this->request['sort_by']);
            $list = $user->get();
        } else {
            $list = User::all();
        }
        return $this->view->render('user', ['title' => 'Список пользователей', 'users' => $list]);
    }

    public function getCreate()  // render добавления пользователя
    {
        return $this->view->render('user-add', ['title' => 'Создание нового пользователя', 'errors' => $this->errors]);
    }

    public function postCreate() //запрос на добавление пользователя и обработка ошибок
    {
        //валидация формы
        $errors = [];
        if (empty($this->request['username'])) {
            $errors[] = "User name not filled";
        }

        if (empty($this->request['age'])) {
            $errors[] = "User age not filled";
        }
//        if (empty($this->request['details'])) {
//            $errors[] = "User details not filled";
//        }
//        if (empty($this->request['password'])) {
//            $errors[] = "User password not filled";
//        } else {
//
//        }

        $this->request['password'] = md5($this->request['password']);

        if (count($errors)) {
            return Helpers::redirect(
                $this->request['route'],
                [
                    'error_message' => implode('::', $errors),
                ]
            );
        }

        //добавление пользователя из формы в фс

        $user = new User();
        $user->fill($this->request);
        if (!$user->save()) {
//            return Helpers::redirect(
//                $this->request['route'],
//                [
//                    'error_message' => 'Не удалось сохранить в БД',
//                ]
//            );
            header('Location: http//' . $_SERVER['SERVER_NAME'] . '/base/404', false, 302);
            exit();

        }
        $this->addFile($user);
//        return Helpers::redirect('user/index');
    }

    public function addFile(User $user)
    {
//        if (!empty($this->request['files']['user_photo']['tmp_name'])) {
//            $fileName = $this->request['files']['user_photo']['name'];
//
//            if ($this->fileManager->make($this->request['files']['user_photo']['tmp_name'])->save(
//                $this->dirUpload . '/' . $fileName
//            )) {
//                (new File())->fill(
//                    [
//                        'user_id' => $user->id,
//                        'url' => $fileName,
//                    ]
//                )->save();
//            }
//        } else {
//            return Helpers::redirect(
//                $this->request['route'],
//                [
//                    'error_message' => 'Неизвестная ошибка',
//                ]
//            );
//        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_FILES['user_photo']['error'] == UPLOAD_ERR_OK && $_FILES['user_photo']['type'] == 'image/jpeg') {
                $uploaddir = __DIR__ . '/../../Uploads/';
                $filename = md5($user->id) . '.jpeg';
                $uploadfile = $uploaddir . $filename;

                if (move_uploaded_file($_FILES['user_photo']['tmp_name'], $uploadfile)) {
                    $file = new File();
                    $file->fill([
                        'user_id' => $user->id,
                        'url' => $filename
                    ]);

                    $file->save();
                    $this->watermark($filename);

                    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/user/index', false, 302);
                    exit();
                }
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/base/404', false, 302);
                exit();
            }

        }
    }

    public function watermark($filename)
    {
        $image = IImage::make(__DIR__ . '/../../Uploads/' . $filename);
        $image->rotate(45)
            ->text(
                'Moй сайт',
                $image->width() / 2,
                $image->height() / 2,
                function ($font) {
                    $font->file(__DIR__ . '/../../arial.ttf')->size('150');
                    $font->color(array(255, 0, 0, 0.5));
                    $font->align('center');
                    $font->valign('center');
                })
            ->resize(500, null, function ($image) {
                $image->aspectRatio();
            });
        $image->save(__DIR__ . '/../../Uploads/' . $filename);
    }

    public function postAuth()
    {
        $user = User::where('email', $this->request['email'])->where('password', md5($this->request['password']))->first();
        if ($user->exists) {
            $_SESSION['user'] = $user->toArray();
            Helpers::redirect('user/index');
        } else {
            header('Location:' . $_SERVER['SERVER_NAME'] . '/register/index', false, 302);
        }
    }

    public function getAuthOut()
    {
        $_SESSION['user'] = null;
        return header('Location: http://' . $_SERVER['SERVER_NAME'] . '/auth/index', false, 302);
    }

}