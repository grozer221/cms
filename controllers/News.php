<?php


namespace controllers;

use core\Controller;

/**
 * Контролер для модуля News
 * @package  controllers
 */
class News extends Controller
{
    protected $usersModel;
    protected $user;
    protected $newsModel;
    public function __construct()
    {
        $this->usersModel = new \models\Users();
        $this->newsModel = new \models\News();
        $this->user = $this->usersModel->getCurrentUser();
    }
    /**
     * Відображення початкової сторінки модуля
     */
    public function actionIndex()
    {
        $title = 'Новини';
        global $Config;
        $lastNews = $this->newsModel->getLastNews($Config['NewsCount']);
        return $this->render('index', ['lastNews' => $lastNews], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
    /**
     * Перегляяд новини
     */
    public function actionView()
    {
        return $this->render('index', ['count' => 10], [
            'PageTitle' => 'Новини',
            'MainTitle' => 'Новини'
        ]);
    }
    /**
     * Додавання новини
     */
    public function actionAdd()
    {
        $titleForbidden = 'Доступ заборонено';
        if(empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Додавання новини';
        if($this->isPost()){
            $result = $this->newsModel->addNews($_POST);
            if($result === true)
                return $this->renderMessage('success', 'Новина успішно додана', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            else
            {
                $message = implode('<br/>', $result);
                return $this->render('add', null, [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else
            return $this->render('add', null, [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    /**
     * Редагування новини
     */
    public function actionEdit()
    {
        return $this->render('index', ['count' => 10], [
            'PageTitle' => 'Новини',
            'MainTitle' => 'Новини'
        ]);
    }
    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        return $this->render('index', ['count' => 10], [
            'PageTitle' => 'Новини',
            'MainTitle' => 'Новини'
        ]);
    }
}