<form method="post" action="" class="login-register-form bg-light">
    <h1 class="text-center">Вхід на сайт</h1>
    <div class="mb-3"   >
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="login" value="<?=$_POST['login'] ?>" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="submit btn btn-primary">Submit</button>
</form>
