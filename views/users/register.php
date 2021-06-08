<?php
$userModel = new \models\Users();
$user = $userModel->getUserById($model['id']);
?>
<form method="post" action="" class="login-register-form bg-light">
    <h1 class="text-center"><?= $PageTitle ?></h1>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">E-mail</label>
        <input type="email" name="login" value="<?= $model['login'] ?>" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Пароль ще раз</label>
        <input type="password" name="password2" class="form-control" id="exampleInputPassword2">
    </div>
    <div class="mb-3">
        <label for="firstname" class="form-label">Ім'я</label>
        <input type="text" name="firstname" value="<?= $model['firstname'] ?>" class="form-control" id="firstname">
    </div>
    <div class="mb-3">
        <label for="lastname" class="form-label">Прізвище</label>
        <input type="text" name="lastname" value="<?= $model['lastname'] ?>" class="form-control" id="lastname">
    </div>
    <? if($userModel->isUserAuthenticated() && $userModel->isUserAccessIsAdmin()) : ?>
        <div class="mb-3">
            <label for="access" class="form-label">Права доступу</label>
            <select class="form-control" name="access" id="access">
                <? if($user['access'] === 'user') : ?>
                    <option selected>user</option>
                <? else: ?>
                    <option>user</option>
                <? endif; ?>
                <? if($user['access'] === 'editor') : ?>
                    <option selected>editor</option>
                <? else: ?>
                    <option>editor</option>
                <? endif; ?>
                <? if($user['access'] === 'admin') : ?>
                    <option selected>admin</option>
                <? else: ?>
                    <option>admin</option>
                <? endif; ?>
            </select>
        </div>
    <? endif; ?>
    <button type="submit" class="submit btn btn-primary text-center">Зберегти</button>
</form>
