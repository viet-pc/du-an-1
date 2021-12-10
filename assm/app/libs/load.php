<?php
class load
{
    function model($model)
    {
        require_once "./app/models/" . "$model" . ".php";
        return new $model;
    }
    function view($view, $data = [])
    {
        require_once "./app/views/" . "$view" . ".php";
    }
    function ktlogin()
    {
        if (isset($_SESSION['username']) == true) {
            return $_SESSION['username'];
        } else {
            return FALSE;
        }
    }
    function getusernames()
    {
        if (isset($_COOKIE['username'])) {
            return $_COOKIE['username'];
        } else {
            return 'chưa dang nhập';
        };
    }
    function LucNayLa()
    {

        $anh = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "am", "pm", ":");

        $viet = array("Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy", "Chủ nhật", " phút, sáng", " phút, chiều", " giờ ");

        $timenow = gmdate("D, d/m/Y - g:i a.", time() + 7 * 3600);

        $t = str_replace($anh, $viet, $timenow);

        return $t;
    }
    function ktdangnhap()
    {
        if (isset($_SESSION['login_id']) == false) {
            $_SESSION['back'] = $_SERVER['REQUEST_URI'];
            $_SESSION['thongbao'] = "Bạn chưa đăng nhập";
            header('location:  ' . BASE_URL . 'admin/login');
        }
    }
}
