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
        if(!$this->usersModel->isUserAccessIsAdmin())
            if(isset($_SESSION['user'])){
                header('Location: /');
                return;
            }
        $title = 'Реєстрація на сайті';
        if($this->isPost())
        {
            $result = $this->usersModel->addUser($_POST);
            if($result === true)
                return $this->renderMessage('success', 'Користувач успішно зареєстрований', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            else
            {
                $message = implode('<br/>', $result);
                return $this->render('register', null, [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        }
        else{
            return $this->render('register', null,
                [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
        }
    }
    public function actionIndex()
    {
        if(!$this->usersModel->isUserAccessIsAdmin())
            return $this->renderForbidden();
        $title = 'Користувачі';
        global $Config;
        return $this->render('index', ['lastUsers' => $this->usersModel->getLastUsers($Config['UsersCount'])],
            [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    public function actionEdit()
    {
        $title = 'Редагування користувача';
        if(empty($_GET['id']) || !$this->usersModel->isUserAccessIsAdmin())
            return $this->renderForbidden();
        $id = $_GET['id'];
        $user = $this->usersModel->getUserById($id);
        if($this->isPost()) {
            $result = $this->usersModel->updateUser($_POST, $id);
            if ($result === true)
            {
                return $this->renderMessage('success', 'Користувача успішно відредаговано', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            }
            else
            {
                $message = implode('<br/>', $result);
                return $this->render('register', ['model' => $user], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else
            return $this->render('register', ['model' => $user], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
}