<form method="post" action="">
    <div class="mb-3">
        <label for="title" class="form-label">Заголовок новини</label>
        <input type="text" name="title" value="<?=$_POST['title'] ?>" class="form-control" id="title">
    </div>
    <div class="mb-3">
        <label for="short-text" class="form-label">Заголовок новини</label>
        <textarea name="short_text" class="form-control" id="short-text"><?=$_POST['short-text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Заголовок новини</label>
        <textarea name="text" class="form-control" id="text"><?=$_POST['text'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>