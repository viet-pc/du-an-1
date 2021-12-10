<div id="thongtin">
    <form action="<?= BASE_URL . '/buyer/regiter' ?>" method="post">
        <div class="tieude">
            <img width="50" src="<?= BASE_URL . '/img/edit.png' ?>" alt="">
            <h6> ĐĂNG KÝ</h6>
        </div>

        <label class="input">
            <input class="input__field" name="hvt" type="text" placeholder=" " />
            <span class="input__label">Nhập họ và tên</span>
        </label>
        <label class="input">
            <input class="input__field" name="dc" type="text" placeholder=" " />
            <span class="input__label">Nhập địa chỉ</span>
        </label>
        <label class="input">
            <input class="input__field" name="sdt" type="text" placeholder=" " />
            <span class="input__label">Nhập mã số điện thoại</span>
        </label>
        <label class="input">
            <input class="input__field" name="email" type="email" placeholder=" " />
            <span class="input__label">Nhập Email</span>
        </label>
        <label class="input">
            <input class="input__field" name="tdn" type="text" placeholder=" " />
            <span class="input__label">Nhập tên đăng nhập</span>
        </label>
        <label class="input">
            <input class="input__field" name="pass" type="password" placeholder=" " />
            <span class="input__label">Nhập Mật Khẩu Của Bạn</span>
        </label>
        <label class="input">
            <input class="input__field" name="pass2" type="password" placeholder=" " />
            <span class="input__label">Nhập lại Mật Khẩu Của Bạn</span>
        </label>
        <div class="mess">
            <?php if ($data['mess'] != '') {
                echo $data['mess'];
            } ?>
        </div>
        <div class="btn">
            <div class=" dk animated-button victoria-one"><input name="btn-submit" type="submit" value="Đăng ký"></div>
            <a class="dk animated-button victoria-two" href="<?= BASE_URL . '/buyer/login' ?>"><span>Đăng Nhập</span> </a>
        </div>
    </form>
</div>