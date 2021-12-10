<?php
class bag extends load
{
    function index()
    {
        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }
        $viet = $this->model('homemodel');
        $this->view('trang1', [
            'loaisp' => $arr,
            'NhaSX' => $sp->getNhaSX(),
            'sp' => $sp->getsv(),
            'viet' => $viet->getsv(),
            'login' => $this->ktlogin(),
            'ngay' => $this->LucNayLa(),
            'page' => 'bag',
            'tag' => [
                'horizontalproductlist',
                'map'
            ],
        ]);
    }
}
