<?php
    $userModel = new \models\Users();
    $user = $userModel->getCurrentUser();
?>
<? if($userModel->isUserAuthenticated() && !$userModel->isUserAccessIsUser()) : ?>
    <a  class="mb-4 mt-2 btn btn-success" href="/news/add">Створити новину</a>
<? endif;?>
<?php foreach ($lastNews as $news) : ?>
    <?php $pathinfo = pathinfo($news['photo']); ?>
    <div class="news-record mb-4">
        <h3><?= $news['title'] ?></h3>
        <div class="wrapper-photo">
            <? if(is_file('files/news/'.$pathinfo['filename'].'_s.'.$pathinfo['extension'])) : ?>
                <img src="/files/news/<?= $pathinfo['filename'].'_s.'.$pathinfo['extension'] ?>" class="float-start photo">
            <? else: ?>
                <img src="/files/news/empty.png" class="float-start photo">
            <? endif ?>
        </div>
        <div>
            <?= $news['short_text'] ?>
        </div>
        <div class="buttons">
            <a class="btn btn-primary" href="/news/view?id=<?= $news['id']?>">Читати далі</a>
            <? if($userModel->isUserAccessIsAdmin() || $news['user_id'] == $user['id']) : ?>
                <a class="btn btn-success" href="/news/edit?id=<?= $news['id']?>">Редагувати</a>
                <a class="btn btn-danger" href="/news/delete?id=<?= $news['id']?>">Видалити</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>