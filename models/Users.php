<?php
namespace models;

use core\Core;
use core\Utils;

class Users extends \core\Model
{
    public  function AddUser($userRow)
    {
        $fields = ['login', 'password', 'firstname', 'lastname'];
        $userRow = Utils::arrayFilter($userRow, $fields);
        $user = $this->getUserByLogin($userRow['login']);
        if(!empty($user))
            return false;
        $userRow['password'] = md5($userRow['password']);
        \core\Core::getInstance()->getDB()->insert('users', $userRow);
        return true;
    }
    public function authUser($login, $password)
    {
        $password = md5($password);
        Core::getInstance()->getDB()->select('users',
        [
            'login' => $login,
            'password' => $password
        ]);
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
}