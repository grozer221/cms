<?php


namespace controllers;


use core\Controller;

class NotFound extends Controller
{
    public function actionIndex()
    {
        $title = '404 Not Found';
        return $this->render('index', null, [
            'MainTitle' => $title,
            'PageTitle' => $title
        ]);
    }
}