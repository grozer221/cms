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
    public function actionRegister()
    {
        if($this->isPost())
        {
            $result = $this->usersModel->addUser($_POST);
            if(!empty($result))
                return $this->renderMessage('success', 'Користувач успішно зареєстрований', null,
                    [
                        'PageTitle' => 'Реєстрація на сайті',
                        'MainTitle' => 'Реєстрація на сайті'
                    ]);
            else
            {
                return $this->render('register', null, [
                        'PageTitle' => 'Реєстрація на сайті',
                        'MainTitle' => 'Реєстрація на сайті',
                        'MessageText' => 'Користувач із заданим логіном уже існує',
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