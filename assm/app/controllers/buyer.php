<?php
class buyer extends load
{
    function index()
    {
        if ($this->ktlogin()) {
            header('Location: ' . BASE_URL . 'giohang');
        } else {
            header('Location: ' . BASE_URL . 'buyer/login');
        }
    }
    function login()
    {
        if ($this->ktlogin() == false) {
            $sp = $this->model('homemodel');
            $arr = array();
            foreach ($sp->getLoaiSP() as $key => $value) {
                $arr[$key] = $value;
            }
            $user = $this->model('loginmodel');
            $tk = $user->getUP();
            $mess = '';

            if (isset($_POST['btn_dangnhap'])) {
                $username = trim(strip_tags($_POST['username']));
                $password = trim(strip_tags($_POST['pass']));
                if ($username != '' && $password != '') {
                    $kq = FALSE;
                    foreach ($tk as $use) {
                        if ($use['username'] == $username && $use['password'] == $password) {
                            $kq = TRUE;
                        }
                    }

                    if (!$kq) {
                        $mess = 'Tài khoản hoặc mật khẩu không chính xác';
                    } else {
                        $mess = 'dang nhap thanh cong';
                        $_SESSION['username'] = $username;
                        header('Location: ' . BASE_URL);
                    }
                } else {
                    $mess = 'vui lòng nhập đầy đủ thông tin';
                }
            }
            $this->view('trang1', [
                'loaisp' => $arr,
                'NhaSX' => $sp->getNhaSX(),
                'login' => $this->ktlogin(),
                'ngay' => $this->LucNayLa(),
                'mess' => $mess,
                'page' => 'login'
            ]);
        } else {
            header('Location: ' . BASE_URL);
        }
    }
    function regiter()
    {
        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }
        $regitermd = $this->model('regitermodel');
        $mess = '';

        if (isset($_POST['btn-submit'])) {
            $hvt = trim(strip_tags($_POST['hvt']));
            $sdt = trim(strip_tags($_POST['sdt']));
            $email = trim(strip_tags($_POST['email']));
            $tdn = trim(strip_tags($_POST['tdn']));
            $pass = trim(strip_tags($_POST['pass']));
            $pass2 = trim(strip_tags($_POST['pass2']));
            $dc = trim(strip_tags($_POST['dc']));
            if ($hvt != '' && $tdn != '' && $pass2 != '' && $sdt != '' && $pass != '' && $email != '' && $dc != '') {
                if ($pass != $pass2) {
                    $mess = 'Nhập lại mật khâu không đúng';
                } else {
                    $kq = TRUE;
                    $kh = $regitermd->getkh();
                    foreach ($kh as $use) {
                        if ($use['username'] == $tdn) {
                            $mess = 'tên đăng nhập đa đã đăng ký';
                            $kq = FALSE;
                            break;
                        } else if ($use['Email'] == $email) {
                            $mess = 'email đã đã đăng ký';
                            $kq = FALSE;
                            break;
                        } else if ($use['SoDT'] == $sdt) {
                            $mess = 'số điện thoại đã đã đăng ký';
                            $kq = FALSE;
                            break;
                        } else {
                            $kq = TRUE;
                        }
                    }
                    if ($kq) {
                        $kh = [$hvt, $pass, $sdt, $email, $dc, $tdn];
                        $regitermd->insertkh($hvt, $sdt, $email, $tdn, $pass, $dc);
                        $_SESSION['username'] = $tdn;
                    }
                }
            } else {
                $mess = 'Vui lòng nhập đầy đủ thông tin';
            }
        }
        if ($this->ktlogin() != FALSE) {
            // header("Location: ../home");
        } else {
            $this->view('trang1', [
                'loaisp' => $arr,
                'NhaSX' => $sp->getNhaSX(),
                'ngay' => $this->LucNayLa(),
                'mess' => $mess,
                'login' => $this->ktlogin(),
                'page' => 'regiter',
            ]);
        }
    }
    function changePassword()
    {
        $thongbao = "";
        if (isset($_POST['btn-submit'])) {
            if (session_id() == '') session_start();
            if (isset($_SESSION['username']) == false) {
                header('Location ' . BASE_URL . 'login.php');
                exit();
            }

            $u = $_SESSION['username'];
            //tiếp nhận dữ liệu từ form
            $pass_old = trim(strip_tags($_POST['pass_old']));

            $pass_new1 = trim(strip_tags($_POST['pass_new1']));

            $pass_new2 = trim(strip_tags($_POST['pass_new2']));

            if ($pass_new1 == '' || $pass_new1 == '' || $pass_old == '') {
                $thongbao .= "vui lòng nhập đầy đủ thông tin";
            } else {
                $buyer = $this->model('buyermodel');
                $rows = $buyer->checkpass($u, $pass_old);
                if ($rows[0] != 1) {
                    $thongbao .= "Mật khẩu củ không đúng nha ";
                } else {
                    if (strlen($pass_new1) < 6) {
                        $thongbao .= "Mật khẩu quá ngắn";
                    }

                    if ($pass_new1 != $pass_new2) {
                        $thongbao .= "mật khẩu mới không khớp";
                    }


                    if ($thongbao == "") {
                        $kq = $buyer->updatepass($pass_new1, $u);

                        if ($kq == 1) $thongbao = "Đã cập nhật thành công";

                        else $thongbao = "Chưa cập nhật được";
                    }
                }
            }
        }

        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }
        $this->view('trang1', [
            'loaisp' => $arr,
            'mess' => $thongbao,
            'NhaSX' => $sp->getNhaSX(),
            'login' => $this->ktlogin(),
            'ngay' => $this->LucNayLa(),
            'page' => 'changepass'
        ]);
        // <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">

        // <div class="col-8 m-auto">

        //     <div class="alert alert-danger mt-5 text-center ">

        //         <?= $thongbao 

        //         <button class="btn btn-primary" onclick="history.back()">Trở lại</button>

        //         <a href="index.php" class="btn btn-info">Trang chủ</a>

        //     </div>

        // </div>
        // }
    }
}
