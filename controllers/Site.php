<?php


namespace controllers;


class Site
{
    public function actionIndex()
    {
        return $result=[
            'Title' => 'Заголовок',
            'Content' => 'Контент'
        ];
        return $result;
    }
}