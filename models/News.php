<?php

namespace models;

use core\Core;
use core\Utils;
use Imagick;

class News extends \core\Model
{
    protected static $folder = 'files/news/';
    public function ChangePhoto($id, $fileInput)
    {
        self::$folder = 'files/news/';
        $pathInfoFileInput = pathinfo(self::$folder.$fileInput);
        $file_big = $pathInfoFileInput['filename'].'_b.'.$pathInfoFileInput['extension'];
        $file_middle = $pathInfoFileInput['filename'].'_m.'.$pathInfoFileInput['extension'];
        $file_small = $pathInfoFileInput['filename'].'_s.'.$pathInfoFileInput['extension'];
        $news = $this->getNewsById($id);
        $pathInfoPhotoInDB = pathinfo(self::$folder.$news['photo']);
        if(is_file(self::$folder.$pathInfoPhotoInDB['filename'].'.'.$pathInfoPhotoInDB['extension']) && is_file(self::$folder.$fileInput))
            unlink(self::$folder.$pathInfoPhotoInDB['filename'].'.'.$pathInfoPhotoInDB['extension']);
        if(is_file(self::$folder.$pathInfoPhotoInDB['filename'].'_b.'.$pathInfoPhotoInDB['extension']) && is_file(self::$folder.$fileInput))
            unlink(self::$folder.$pathInfoPhotoInDB['filename'].'_b.'.$pathInfoPhotoInDB['extension']);
        if(is_file(self::$folder.$pathInfoPhotoInDB['filename'].'_m.'.$pathInfoPhotoInDB['extension']) && is_file(self::$folder.$fileInput))
            unlink(self::$folder.$pathInfoPhotoInDB['filename'].'_m.'.$pathInfoPhotoInDB['extension']);
        if(is_file(self::$folder.$pathInfoPhotoInDB['filename'].'_s.'.$pathInfoPhotoInDB['extension']) && is_file(self::$folder.$fileInput))
            unlink(self::$folder.$pathInfoPhotoInDB['filename'].'_s.'.$pathInfoPhotoInDB['extension']);
        $news['photo'] = $fileInput;
        $im_b = new Imagick();
        $im_b->readImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.$fileInput);
        $im_b->cropThumbnailImage(1280,1024, true);
        $im_b->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.'/'.$file_big);
        $im_m = new Imagick();
        $im_m->readImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.$fileInput);
        $im_m->cropThumbnailImage(300,200, true);
        $im_m->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.'/'.$file_middle);
        $im_s = new Imagick();
        $im_s->readImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.$fileInput);
        $im_s->cropThumbnailImage(180,180, true);
        $im_s->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.self::$folder.'/'.$file_small );
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
        Core::getInstance()->getDB()->update('news', $rowFiltered, ['id' => $id]);
        return true;
    }
    public function deleteNews($id)
    {
        $news = $this->getNewsById($id);
        $userModel = new Users();
        $user = $userModel->getCurrentUser();
        if(!$userModel->isUserAccessIsAdmin() && !empty($news))
            if(empty($user) || $user['id'] != $news['user_id'])
                return false;
        $this->deletePhotos($news['photo']);
        Core::getInstance()->getDB()->delete('news', ['id' => $id]);
        return true;
    }
    public function deletePhotos($namePhoto)
    {
        $pathInfoPhoto = pathinfo(self::$folder.$namePhoto);
        if(is_file(self::$folder.$pathInfoPhoto['filename'].'.'.$pathInfoPhoto['extension']))
            unlink(self::$folder.$pathInfoPhoto['filename'].'.'.$pathInfoPhoto['extension']);
        if(is_file(self::$folder.$pathInfoPhoto['filename'].'_b.'.$pathInfoPhoto['extension']))
            unlink(self::$folder.$pathInfoPhoto['filename'].'_b.'.$pathInfoPhoto['extension']);
        if(is_file(self::$folder.$pathInfoPhoto['filename'].'_m.'.$pathInfoPhoto['extension']))
            unlink(self::$folder.$pathInfoPhoto['filename'].'_m.'.$pathInfoPhoto['extension']);
        if(is_file(self::$folder.$pathInfoPhoto['filename'].'_s.'.$pathInfoPhoto['extension']))
            unlink(self::$folder.$pathInfoPhoto['filename'].'_s.'.$pathInfoPhoto['extension']);
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