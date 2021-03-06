<?php $userModel = new \models\Users() ?>
<? if($userModel->isUserAccessIsAdmin()) : ?>
    <div class="align-right mt-2 mb-4">
        <a class=" btn btn-success" href="/users/register">Створити користувача</a>
    </div>
    <?php foreach ($lastUsers as $user) : ?>
        <div class="user-record mb-4">
            <div>
                <h5><?= $user['firstname'].' '.$user['lastname'] ?></h5>
                <div>Id: <?= $user['id'] ?></div>
                <div>Email: <?= $user['login'] ?></div>
                <div>Права доступу: <?= $user['access'] ?></div>
            </div>
            <div>
                <a class="btn btn-success" href="/users/edit?id=<?= $user['id']?>">Редагувати</a>
                <a class="btn btn-danger" href="/users/delete?id=<?= $user['id']?>">Видалити</a>
            </div>
        </div>
    <?php endforeach; ?>
<? endif; ?>

