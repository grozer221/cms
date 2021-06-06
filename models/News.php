<?php


namespace models;


use core\Core;
use core\Utils;

class News extends \core\Model
{
    public function ChangePhoto($id, $file)
    {
        $folder = 'files/news/';
        $news = $this->getNewsById($id);
        if(is_file($folder.$news['photo']) && is_file($folder.$file))
            unlink($folder.$news['photo']);
        $news['photo'] = $file;
        $this->updateNews($news, $id);
    }
    public function addNews($row)
    {
        $userModel = new Users();
        $user = $userModel->getCurrentUser();
        if($user === null){
            return [
                'error' => true,
                'messages' => ['Користувач не аутентифікований']
            ];
        }
        $validateResult = $this->Validate($row);
        if(is_array($validateResult)){
            return [
                'error' => true,
                'messages' => $validateResult
            ];
        }
        $fields = ['title', 'short_text', 'text'];
        $rowFiltered = Utils::arrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $rowFiltered['user_id'] = $user['id'];
        $rowFiltered['photo'] = 'photo';
        $id = \core\Core::getInstance()->getDB()->insert('news', $rowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }
    public function getLastNews($count)
    {
        return \core\Core::getInstance()->getDB()->select('news', '*', null, ['datetime' => 'DESC'], $count);
    }
    public function getNewsById($id){
        $news = \core\Core::getInstance()->getDB()->select('news', '*', ['id' => $id]);
        if(!empty($news))
            return $news[0];
        else
            return null;
    }
    public function updateNews($row, $id)
    {
        $userModel = new Users();
        $user = $userModel->getCurrentUser();
        if($user === null)
            return false;
        $validateResult = $this->Validate($row);
        if(is_array($validateResult))
            return $validateResult;
        $fields = ['title', 'short_text', 'text', 'photo'];
        $rowFiltered = Utils::arrayFilter($row, $fields);
        $rowFiltered['datetime_lastedit'] = date('Y-m-d H:i:s');
        //$rowFiltered['user_id'] = $user['id'];
        //$rowFiltered['photo'] = 'photo';
        Core::getInstance()->getDB()->update('news', $rowFiltered, ['id' => $id]);
        return true;
    }
    public function deleteNews($id)
    {
        $news = $this->getNewsById($id);
        $userModel = new Users();
        $user = $userModel->getCurrentUser();
        if($user === null)
            return false;
        if(empty($news) || empty($user) || $user['id'] != $news['user_id'])
            return false;
        Core::getInstance()->getDB()->delete('news', ['id' => $id]);
        return true;
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