<?php
class home extends load
{
    function index()
    {
        if (isset($_GET['dangxuat'])) {
            unset($_SESSION['username']);
        }
        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }
        $this->view('trang1', [
            'sp' => $sp->getsv(),
            'loaisp' => $arr,
            'NhaSX' => $sp->getNhaSX(),
            'login' => $this->ktlogin(),
            'ngay' => $this->LucNayLa(),
            'tag' => [
                'banner',
                'how-wear',
                'video',
                'horizontalproductlist',
            ]
        ]);
    }
}
