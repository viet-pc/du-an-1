<?php
class admin extends load
{
    function __construct()
    {
    }
    function index()
    {
        $this->ktdangnhap();
        $sp = $this->model('adminmodel');
        $this->view('trang2', [
            'sp' => $sp->getsp(),
            // 'login' => $this->ktlogin(),
            'tag' => [
                'sanpham',
            ],
        ]);
    }
    function sanpham($mess)
    {
        $this->ktdangnhap();
        $sp = $this->model('adminmodel');
        $this->view('trang2', [
            'sp' => $sp->getsp(),
            'mess' => $mess,
            // 'login' => $this->ktlogin(),
            'tag' => [
                'sanpham',
            ],
        ]);
    }
    function them()
    {
        $mess = '';
        function kienTraAnh($anh)
        {
            if ($anh['type'] == "image/jpeg" || $anh['type'] == "image/png" || $anh['type'] == "image/gif") {
                return TRUE;
            }
        }
        if (isset($_POST['submit'])) {
            if ($_POST['tensp'] != '' && $_POST['giaCu'] != '' && $_POST['giamoi'] != '' && $_POST['giotinh'] != '' && $_POST['MaNSX'] != '' && $_POST['loaisp'] != '' && $_FILES['anhchinh']['name'] != NULL && $_FILES['anhphu']['name'] != NULL) {
                foreach ($_FILES['anhphu']['tmp_name'] as $file) {
                    $tmp_name[] = $file;
                }
                $anhchinh = $_FILES['anhchinh'];
                $numitems = count($_FILES['anhphu']['name']);
                if (kienTraAnh($anhchinh) == TRUE && $numitems > 0) {
                    if ($numitems >= 3) {
                        $keyimg = [];
                        //var_dump($name);
                        array_splice($_FILES['anhphu']['name'], 1, 0, $anhchinh['name']);
                        array_splice($_FILES['anhphu']['tmp_name'], 1, 0, $anhchinh['tmp_name']);
                        // var_dump($tmp_name);

                        $numitems = count($_FILES['anhphu']['name']);
                        foreach ($_FILES['anhphu']['name'] as $key => $value) {

                            $n = $key + 1;
                            array_push($keyimg, 'anh' . $n);


                            $filename = $_FILES['anhphu']['name'][$key];
                            $tmp_name = $_FILES['anhphu']['tmp_name'][$key];

                            $upload_dir = "img/";
                            $upload_file = $upload_dir . $filename;
                            // if (!file_exists($upload_file)) {
                            if (move_uploaded_file($tmp_name, $upload_file)) {
                                var_dump($_FILES['anhphu']['name'][$key]);
                            } else $mess = 'loi';
                            // } else {
                            //     $mess = 'file đã tồn tại';
                            // }
                        }
                        for ($i = 0; $i < $numitems; $i++) {
                        }
                        $name = array_combine($keyimg, $_FILES['anhphu']['name']);

                        $id = $this->model('adminmodel')->themanhsp($name);
                        $data = [
                            'TenSP' => $_POST['tensp'],
                            'GiaCu' => $_POST['giaCu'],
                            'GiaMoi' => $_POST['giamoi'],
                            'gioitinh' => $_POST['giotinh'],
                            'MaNSX' => $_POST['MaNSX'],
                            'Maloai' => $_POST['loaisp'],
                            'MaAnh' => $id
                        ];
                        if (isset($_POST['add'])) {
                            $this->model('adminmodel')->themsp($data);
                        } else {
                            $str = 'MaSP = ' . $_POST['change'];
                            $this->model('adminmodel')->update('sanpham', $data, $str);
                        }
                    } else {
                        $mess = 'ảnh thêm trên 3 ảnh';
                    }
                } else {
                    $mess = "không phải ảnh";
                }
            } else {
                $mess = 'vui lòng nhập đầu đủ thông tin';
            }
        }
        header('location: ' . BASE_URL . 'admin/sanpham/' . $mess . '');
    }
    function xoa()
    {
        $sp = $this->model('adminmodel');
        if (isset($_GET['xoaid'])) {
            $sp->remove($_GET['xoaid']);
            header('location: ' . BASE_URL . 'admin');
        }
    }
    function xoakh()
    {
        $sp = $this->model('adminmodel');
        if (isset($_GET['xoaid'])) {
            $sp->xoakh($_GET['xoaid']);
            header('location: ' . BASE_URL . 'admin/khachhang');
        }
    }
    function khachhang()
    {
        $this->ktdangnhap();
        $sx = $this->model('adminmodel');
        $this->view('trang2', [
            'kh' => $sx->getkh(),
            'tag' => ['khachhang']
        ]);
    }
    function themkh()
    {
        $regitermd = $this->model('regitermodel');
        $mess = '';
        if (isset($_POST['submit'])) {
            $hvt = trim(strip_tags($_POST['hvt']));
            $sdt = trim(strip_tags($_POST['sdt']));
            $email = trim(strip_tags($_POST['email']));
            $tdn = trim(strip_tags($_POST['tdn']));
            $pass = trim(strip_tags($_POST['pass']));
            $dc = trim(strip_tags($_POST['dc']));
            if ($hvt != '' && $tdn != '' && $sdt != '' && $pass != '' && $email != '' && $dc != '') {
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
                    if (isset($_POST['add'])) {
                        $regitermd->insertkh($hvt, $sdt, $email, $tdn, $pass, $dc);
                        $_SESSION['username'] = $tdn;
                        $mess = 'thanh công';
                    } else {
                        $mess = 'thanh công';
                    }
                }
            } else {
                $mess = 'Vui lòng nhập đầy đủ thông tin';
            }
            echo $mess;
        }
    }
    function login()
    {
        if (isset($_POST['btn'])) {
            // tiêp nhận user , pass từ form
            $u = $_POST['u'];
            $p = $_POST['p'];

            // validate dữ liệu tiếp nhận
            $u = trim(strip_tags($u));
            $p = trim(strip_tags($p));

            $up = $this->model('adminmodel');
            $kq = $up->ktu($u);

            if ($kq->rowCount() == 0) {
                $_SESSION['thongbao'] = "Username không tồn tại";
                header('location: ' . BASE_URL . '/admin/login');
                exit();
            }

            $kq = $up->ktp($u, $p);

            if ($kq->rowCount() == 0) {
                $_SESSION['thongbao'] = 'Mật khẩu không đúng';
                header('location: ' . BASE_URL . 'admin/login');
                exit();
            }
            // thành công
            $row_user = $kq->fetch();
            $_SESSION['login_id'] = $row_user['username'];
            header('location: ' . $_SESSION["back"]);
        }
        $sx = $this->model('adminmodel');
        $this->view('trang2', [
            'kh' => $sx->getkh(),
            'tb' => $_SESSION['thongbao'],
            'tag' => ['login']
        ]);
    }
}
