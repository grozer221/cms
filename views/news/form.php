<?php
    $filePath = pathinfo($model['photo']);
?>
<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Заголовок новини</label>
        <input type="text" name="title" value="<?=$model['title'] ?>" class="form-control" id="title">
    </div>
    <div class="mb-3">
        <label for="short-text" class="form-label">Короткий текст новини</label>
        <textarea name="short_text" class="form-control editor" id="short-text"><?=$model['short_text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Повний текст новини</label>
        <textarea name="text" class="form-control editor" id="text"><?=$model['text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Фотографія до новини</label>
        <input type="file" name="file" accept="image/png, image/jpeg, image/gif" id="file" class="form-control">
    </div>
    <? if(is_file('files/news/'.$filePath['filename'].'_b.'.$filePath['extension'])) : ?>
        <div class="mb-3">
            <img src="/files/news/<?= $filePath['filename'].'_b.'.$filePath['extension'] ?>">
        </div>
    <? endif; ?>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>