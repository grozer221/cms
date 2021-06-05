<?php


namespace controllers;


use core\Controller;

class Site extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', null, [
            'MainTitle' => 'Головна сторінка',
            'PageTitle' => 'Головна сторінка'
        ]);
    }
}