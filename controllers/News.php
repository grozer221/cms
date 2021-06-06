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
        $id = $_GET['id'];
        $news = $this->newsModel->getNewsById($id);
        $title = $news['title'];
        return $this->render('view', ['model' => $news], [
            'PageTitle' => $title,
            'MainTitle' => $title
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
            if($result['error'] === false)
            {
                $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
                if(is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowedTypes))
                {
                    switch($_FILES['file']['type'])
                    {
                        case 'image/jpeg':
                            $extension = 'jpeg';
                            break;
                        case 'image/gif':
                            $extension = 'gif';
                            break;
                        default:
                            $extension = 'png';
                    }
                    $name = $result['id'].'_'.uniqid().'.'.$extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/'.$name);
                    $this->newsModel->ChangePhoto($result['id'], $name);
                }

                return $this->renderMessage('success', 'Новина успішно додана', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            }
            else
            {
                $message = implode('<br/>', $result['messages']);
                return $this->render('form', ['model' => $_POST], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else
            return $this->render('form', null, [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    /**
     * Редагування новини
     */
    public function actionEdit()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->getNewsById($id);
        $titleForbidden = 'Доступ заборонено';
        if(empty($this->user) || $news['user_id'] != $this->usersModel->getCurrentUser()['id'])
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Редагування новини';
        if($this->isPost()){
            $result = $this->newsModel->updateNews($_POST, $id);
            if($result === true){
                $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
                if(is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowedTypes)) {
                    switch ($_FILES['file']['type']) {
                        case 'image/jpeg':
                            $extension = 'jpeg';
                            break;
                        case 'image/gif':
                            $extension = 'gif';
                            break;
                        default:
                            $extension = 'png';
                    }
                    $name = $id . '_' . uniqid() . '.' . $extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/' . $name);
                    $this->newsModel->ChangePhoto($id, $name);
                }
                return $this->renderMessage('success', 'Новину успішно збережено', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            }

            else
            {
                $message = implode('<br/>', $result);
                return $this->render('form', ['model' => $news], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        }
        else
            return $this->render('form', ['model' => $news], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->getNewsById($id);
        $titleForbidden = 'Доступ заборонено';
        if(empty($this->user) || $news['user_id'] != $this->usersModel->getCurrentUser()['id'])
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Видалення новини';
        if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes')
        {
            if($this->newsModel->deleteNews($id))
                header('Location: /news/');
            else
                return $this->renderMessage('error', 'Помилка видалення новини', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        return $this->render('delete', ['model' => $news], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
}