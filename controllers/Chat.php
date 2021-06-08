<?php

namespace controllers;

use core\Controller;

class Chat extends Controller
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new \models\Users();
    }

    public function actionIndex()
    {
        $title = 'Чат';
        if(!$this->userModel->isUserAuthenticated())
            return $this->renderForbidden();
        else
            return $this->render('index', null,
                [
                    'PageTitle' => $title,
                    'MainTitle' => $title
                ]);
    }
}