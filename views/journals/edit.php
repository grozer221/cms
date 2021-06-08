<form action="/journals/update?id=<?= $model['id'] ?>" method="post">
    <textarea name="marks" id="marks" class="editor"><?= $model['marks'] ?></textarea>
    <button type="submit" class="mt-2 btn btn-success">Зберегти</button>
</form>
