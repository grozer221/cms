<?php


namespace controllers;


use core\Controller;

class Users extends Controller
{
    protected $usersModel;
    function __construct()
    {
        $this->usersModel = new \models\Users();
    }
    function actionLogout()
    {
        $title = 'Вихід із аккаунту';
        unset($_SESSION['user']);
        return $this->renderMessage('success', 'Ви вийшли з вашого аккаунту', null,
            [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    public function actionLogin()
    {
        $title = 'Вхід на сайт';
        if(isset($_SESSION['user'] ))
            return $this->renderMessage('success', 'Ви уже увійшли на сайт', null,
                [
                    'PageTitle' => $title,
                    'MainTitle' => $title
                ]);
        if($this->isPost())
        {
            $user = $this->usersModel->authUser($_POST['login'], $_POST['password']);
            if(!empty($user)){
                $_SESSION['user'] = $user;
                return $this->renderMessage('success', 'Ви успішно увійшли на сайт', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            }
            else{
                return $this->render('login', null, [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => 'Неправильний логін або пароль',
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else{
            $params = [
                'PageTitle' => $title,
                'MainTitle' => $title
            ];
            return $this->render('login', null, $params);
        }
    }
    public function actionRegister()
    {
        if($this->isPost())
        {
            $result = $this->usersModel->addUser($_POST);
            if($result === true)
                return $this->renderMessage('success', 'Користувач успішно зареєстрований', null,
                    [
                        'PageTitle' => 'Реєстрація на сайті',
                        'MainTitle' => 'Реєстрація на сайті'
                    ]);
            else
            {
                $message = implode('<br/>', $result);
                return $this->render('register', null, [
                        'PageTitle' => 'Реєстрація на сайті',
                        'MainTitle' => 'Реєстрація на сайті',
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        }
        else{
            $params = [
                'PageTitle' => 'Реєстрація на сайті',
                'MainTitle' => 'Реєстрація на сайті'
            ];
            return $this->render('register', null, $params);
        }
    }
}