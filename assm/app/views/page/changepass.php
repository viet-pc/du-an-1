<style>
    .border-primary {
        border: 1px solid blue;
        padding: 10px;
    }

    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-size: 2rem;
    }

    .col-5 {
        max-width: 41.666667%;
    }

    input {
        width: 100%;
        font-size: 1.8rem;
        height: 4rem;
        padding-left: 10px;
    }

    #frmlogin {
        margin: 20px auto;
    }

    input[type='submit'] {
        width: 100px;
        height: 50px;
    }

    .btn-primary {

        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
    }

    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
        padding: .7rem 1.4rem;
        font-size: 2rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    button,
    input {
        overflow: visible;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }
</style>


<form action="<?= BASE_URL . '/buyer/changePassword' ?>" method="post" id="frmlogin" class="border border-primary col-5 m-auto p-2">

    <div class="form-group">

        <label>Username</label> <input name="u" type="text" value="<?= $_SESSION['username']; ?>" class="form-control" disabled />

    </div>

    <div class="form-group">

        <label>Mật khẩu cũ</label> <input name="pass_old" type="password" class="form-control" />

    </div>

    <div class="form-group">

        <label>Mật khẩu mới</label> <input name="pass_new1" type="password" class="form-control" />

    </div>

    <div class="form-group">

        <label>Nhập lại mật khẩu mới</label> <input name="pass_new2" type="password" class="form-control" />

    </div>

    <div class="form-group">

        <input name="btn-submit" type="submit" value="Cập nhật" class="btn btn-primary" />

    </div>
    <div class="form-group">

        <label><?= $data['mess'] ?></label>

    </div>
</form>