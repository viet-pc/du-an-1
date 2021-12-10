<section class="khung_dang_nhap">
    <div class="top2">
        <h2>Đăng Nhập</h2>
        <p>Thành viên mới? <a href="<?= BASE_URL . '/buyer/regiter' ?>">Đăng ký</a> tại đây.</p>
    </div>
    <form action="<?= BASE_URL . 'buyer/login' ?>" class="dangnhap" method="post">

        <div class="input">
            <span id="mess_err">
                <?php echo !isset($data['mess']) ? '2222' : $data['mess'] ?>
            </span>
            <p>Số điện thoại hoặc Email</p>
            <input name="username" type="text" onblur="value_emai()" placeholder="Vui Lòng Nhập Số Điện thoại Hoặc Gmail Của Bạn">
            <span id="username_mess">
            </span>
            <p>Mật khẩu</p>
            <input name="pass" type="password" onblur="value_pass()" placeholder="Vui Lòng Nhập Mật Khẩu Của Bạn">
            <a href="<?= BASE_URL . 'buyer/regiter' ?>">Quên mật khẩu?</a>
        </div>
        <div class="nut">
            <input name="btn_dangnhap" type="submit" placeholder="Đăng Nhập" class="btn btn-strong">
            <div class="hoac">
                <div class="gach"></div>
                HOẶC
                <div class="gach"></div>
            </div>
            <button class="btn btn-face"><i class="fab fa-facebook"></i>Facebook</button>
            <button class="btn btn-face "><i class="fab fa-google-plus-square"></i>Google</button>
        </div>
    </form>
</section>