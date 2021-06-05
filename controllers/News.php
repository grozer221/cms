<?php


namespace controllers;

/**
 * Контролер для модуля News
 * @package  controllers
 */
class News
{
    /**
     * Відображення початкової сторінки модуля
     */
    public function actionIndex()
    {
        echo 'actionIndex';
    }
    /**
     * Відображення списку новин
     */
    public function actionList(){
        echo 'actionList';
    }
}