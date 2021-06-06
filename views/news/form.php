<form method="post" action="">
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>