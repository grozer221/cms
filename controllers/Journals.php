<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Model;

class Journals extends Controller
{
    protected $journalsModel;
    protected $usersModel;

    public function __construct()
    {
        $this->journalsModel = new \models\Journals();
        $this->usersModel = new \models\Users();
    }

    public function actionIndex()
    {
        $title = 'Журнали';
        return $this->render('index',
            [
                'primarySchoolJournals' => $this->journalsModel->getJournalsPrimarySchool()
            ],
            [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }

    public function actionEdit()
    {
        if(!$this->usersModel->isUserAuthenticated() || $this->usersModel->isUserAccessIsUser())
            return $this->renderForbidden();
        $id = $_GET['id'];
        $journal = $this->journalsModel->getJornalById($id);
        if(empty($id) || empty($journal))
            header('Location: /notfound/');
        $title = 'Журнал '.$journal[0]['class'].' '.$journal[0]['subject'];
        return $this->render('edit', ['model' => $journal[0]],
            [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
    public function actionView()
    {
        $id = $_GET['id'];
        $journal = $this->journalsModel->getJornalById($id);
        if(empty($id) || empty($journal))
            header('Location: /notfound/');
        $title = 'Журнал '.$journal[0]['class'].' '.$journal[0]['subject'];
        return $this->render('view', ['marks' => $journal[0]['marks']],
            [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
    public function actionUpdate()
    {
        $id = $_GET['id'];
        if(empty($class) || $this->isGet())
            header('Location: /notfound/');
        $this->journalsModel->updateMarks($_POST, $id);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    public function actionAdd()
    {
        if(!$this->usersModel->isUserAuthenticated() || $this->usersModel->isUserAccessIsUser())
            return $this->renderForbidden();
        $title = 'Додавання журналу';
        if($this->isPost()){
            $result = $this->journalsModel->addJournal($_POST);
            if($result['error'] === false)
                header('Location: /journals');
            else
                return $this->renderForbidden();
        }
        else
            return $this->render('add', null, [
                'MainTitle' => $title
            ]);
    }
}