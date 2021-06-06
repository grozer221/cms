<p>Ви дійсно бажаєте видалити новину <strong><?= $model['title'] ?></strong></p>
<p>
    <a href="/news/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Видалити</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Скасувати</a>
</p>