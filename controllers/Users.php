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
        header('Location: /');
    }
    public function actionLogin()
    {
        $title = 'Вхід на сайт';
        if(isset($_SESSION['user'] )){
            header('Location: /');
            return;
        }

        if($this->isPost())
        {
            $user = $this->usersModel->authUser($_POST['login'], $_POST['password']);
            if(!empty($user)){
                $_SESSION['user'] = $user;
                header('Location: /');
                return;
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
        else
            return $this->render('login', null,
                [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
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