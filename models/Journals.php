<?php

namespace models;

use core\Model;
use core\Utils;

class Journals extends Model
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new \models\Users();
    }
    public function updateMarks($row, $id)
    {
        if(!$this->userModel->isUserAccessIsEditor() && !$this->userModel->isUserAccessIsAdmin())
            return false;
        $fields = ['marks'];
        $rowFiltered = \core\Utils::arrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        \core\Core::getInstance()->getDB()->update('journals', $rowFiltered, ['id' => $id]);
        return true;
    }
    public function getJornalById($id)
    {
        return \core\Core::getInstance()->getDB()->select('journals', '*', ['id' => $id]);
    }
    public function getAllClasses()
    {
        return \core\Core::getInstance()->getDB()->select('journals');
    }
    public function getJournalsPrimarySchool()
    {
        return \core\Core::getInstance()->getDB()->select('journals', '*', ['kind_of_school' => 'primary school', ['class' => 'ASC']]);
    }
    public function getSubjectByClass($class)
    {
        return \core\Core::getInstance()->getDB()->select('journals', '*', ['class' => $class, ['class' => 'DESC']]);
    }
    public function addJournal($row)
    {
        if(!$this->userModel->isUserAuthenticated() || $this->userModel->isUserAccessIsUser())
            return [
                'error' => true,
                'messages' => ['Користувач не аутентифікований']
            ];
        $fields = ['class', 'subject'];
        $rowFiltered = Utils::arrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $id = \core\Core::getInstance()->getDB()->insert('journals', $rowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }
}