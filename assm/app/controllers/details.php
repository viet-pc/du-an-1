<?php
class details extends load
{
    function index()
    {
        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }
        $kn = $this->model('detailmodel');
        if (isset($_GET['id'])) {
            $detail = $kn->getallbyid($_GET['id']);
            $kn->increaseviews($_GET['id']);
        } else {
            header('Location: ' . BASE_URL);
        }

        $this->view('trang1', [
            'kq' => $detail,
            'loaisp' => $arr,
            'NhaSX' => $sp->getNhaSX(),
            'ngay' => $this->LucNayLa(),
            'login' => $this->ktlogin(),
            'page' => 'chitiet',
        ]);
    }
}
