<form method="post" action="">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="login" value="<?=$_POST['login'] ?>" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Password</label>
        <input type="password" name="password2" class="form-control" id="exampleInputPassword2">
    </div>
    <div class="mb-3">
        <label for="firstname" class="form-label">First name</label>
        <input type="text" name="firstname" value="<?=$_POST['firstname'] ?>" class="form-control" id="firstname">
    </div>
    <div class="mb-3">
        <label for="lastname" class="form-label">Last name</label>
        <input type="text" name="lastname" value="<?=$_POST['lastname'] ?>" class="form-control" id="lastname">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
