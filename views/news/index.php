<?php
    $userModel = new \models\Users();
    $user = $userModel->getCurrentUser();
?>
<?php foreach ($lastNews as $news) : ?>
    <?php $pathinfo = pathinfo($news['photo']); ?>
    <div class="news-record">
        <h3><?= $news['title'] ?></h3>
        <div class="photo">
            <? if(is_file('files/news/'.$pathinfo['filename'].'_s.'.$pathinfo['extension'])) : ?>
                <div class="mb-3">
                    <img src="/files/news/<?= $pathinfo['filename'].'_s.'.$pathinfo['extension'] ?>" class="bd-placeholder-img rounded float-start">
                </div>
            <? else: ?>
                <div class="mb-3">
                    <svg class="bd-placeholder-img rounded float-start" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 200x200" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em"></text></svg>
                </div>
            <? endif ?>
        </div>
        <div>
            <?= $news['short_text'] ?>
        </div>
        <div>
            <a class="btn btn-primary" href="/news/view?id=<?= $news['id']?>">Читати далі</a>
            <? if($userModel->isUserAccessIsAdmin() || $news['user_id'] == $user['id']) : ?>
                <a class="btn btn-success" href="/news/edit?id=<?= $news['id']?>">Редагувати</a>
                <a class="btn btn-danger" href="/news/delete?id=<?= $news['id']?>">Видалити</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>