<?php


namespace models;


use core\Utils;

class News extends \core\Model
{
    public function addNews($row)
    {
        $userModel = new Users();
        $user = $userModel->getCurrentUser();
        if($user === null)
            return false;
        $validateResult = $this->Validate($row);
        if(is_array($validateResult))
            return $validateResult;
        $fields = ['title', 'short_text', 'text'];
        $rowFiltered = Utils::arrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $rowFiltered['user_id'] = $user['id'];
        $rowFiltered['photo'] = 'photo';
        \core\Core::getInstance()->getDB()->insert('news', $rowFiltered);
        return true;
    }
    public function getLastNews($count)
    {
        return \core\Core::getInstance()->getDB()->select('news', '*', null, ['datetime' => 'DESC'], $count);
    }
    public function Validate($row)
    {
        $errors = [];
        if(empty($row['title']))
            $errors []= 'Поле "Заголовок" не може бути порожнім';
        if(empty($row['short_text']))
            $errors []= 'Поле "Короткий текст" не може бути порожнім';
        if(empty($row['text']))
            $errors []= 'Поле "Текст" не може бути порожнім';
        if(count($errors) > 0)
            return $errors;
        else
            return true;
    }
}