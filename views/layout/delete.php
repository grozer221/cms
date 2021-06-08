<p><?= $MessageText ?> <strong><?= $NameOfDeleted ?></strong>?</p>
<p>
    <a href="/<?= $ModuleName ?>/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Видалити</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Скасувати</a>
</p>