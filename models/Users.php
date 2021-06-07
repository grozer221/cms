<?php
namespace models;

use core\Core;
use core\Utils;

class Users extends \core\Model
{
    public function Validate($formRow)
    {
        $errors = [];
        if(empty($formRow['login']))
            $errors []= 'Поле "Логін" не може бути порожнім';

        $user = $this->getUserByLogin($formRow['login']);
        if(!empty($user))
            $errors []= 'Користувач із заданим логіном уже зареєстрований';

        if(empty($formRow['password']))
            $errors []= 'Поле "Пароль" не може бути порожнім';
        if($formRow['password'] !==$formRow['password2'])
            $errors []= 'Паролі не співпадають';
        if(empty($formRow['firstname']))
            $errors []= 'Поле "Ім\'я" не може бути порожнім';
        if(empty($formRow['lastname']))
            $errors []= 'Поле "Прізвище" не може бути порожнім';
        if(count($errors) > 0)
            return $errors;
        else
            return true;
    }
    public  function AddUser($userRow)
    {
        $validateResult = $this->Validate($userRow);
        if(is_array($validateResult))
            return $validateResult;
        $fields = ['login', 'password', 'firstname', 'lastname'];
        $userRowFiltered = Utils::arrayFilter($userRow, $fields);
        $userRowFiltered['password'] = md5($userRowFiltered['password']);
        \core\Core::getInstance()->getDB()->insert('users', $userRowFiltered);
        return true;
    }
    public function authUser($login, $password)
    {
        $password = md5($password);
        $users = Core::getInstance()->getDB()->select('users', '*',
        [
            'login' => $login,
            'password' => $password
        ]);
        if(count($users) > 0)
        {
            $user = $users[0];
            return $user;
        }
        else
            return false;
    }
    public function getUserByLogin($login)
    {
        $rows = \core\Core::getInstance()->getDB()->select('users', '*',
            ['login' => $login]);
        if(count($rows) > 0)
            return $rows[0];
        else
            return null;
    }
    public function isUserAuthenticated()
    {
        return isset($_SESSION['user']);
    }
    public function getCurrentUser()
    {
        if($this->isUserAuthenticated())
            return $_SESSION['user'];
        else
            return null;
    }
    public function isUserAccessIsAdmin()
    {
        if($_SESSION['user']['access'] === 'admin')
            return true;
        else
            return false;
    }
    public function isUserAccessIsEditor()
    {
        if($_SESSION['user']['access'] === 'editor')
            return true;
        else
            return false;
    }
    public function isUserAccessIsUser()
    {
        if($_SESSION['user']['access'] === 'user')
            return true;
        else
            return false;
    }
}