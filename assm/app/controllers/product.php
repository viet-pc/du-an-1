<?php
class product extends load
{
    function index()
    {
        $sp = $this->model('homemodel');
        $arr = array();
        foreach ($sp->getLoaiSP() as $key => $value) {
            $arr[$key] = $value;
        }

        $listpro = $this->model('broductmodel');
        if (isset($_GET['maloai'])) {
            $listproduct = $listpro->getlistproductsp($_GET['mnsx'], $_GET['maloai']);
        } else {
            $listproduct = $listpro->getlistproduct($_GET['mnsx']);
        }
        $row = $listproduct->rowCount();
        if ($row == 0) {
            $listproduct = '';
        }
        $this->view('trang1', [
            'loaisp' => $arr,
            'NhaSX' => $sp->getNhaSX(),
            'login' => $this->ktlogin(),
            'ngay' => $this->LucNayLa(),
            'ngay' => $this->LucNayLa(),
            'listproduct' =>  $listproduct,
            'page' => 'produc',
        ]);
    }
}
