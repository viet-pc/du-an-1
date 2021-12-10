<form action="<?php echo BASE_URL; ?>admin/login" method="post" class="border border-primary col-5 m-auto p-2">
    <div class="form-group">
        <label>Username</label> <input name="u" type="text" class="form-control" />
    </div>
    <div class="form-group">
        <label>Mật khẩu</label> <input name="p" type="password" class="form-control" />
    </div>
    <div class="form-group">
        <input name="btn" type="submit" value="Đăng nhập" class="btn btn-primary" />
    </div>
    <?php echo $data['tb']; ?>
</form>