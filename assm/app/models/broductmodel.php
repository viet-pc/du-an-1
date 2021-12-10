<?php

class broductmodel extends database
{
    function getlistproduct($id)
    {

        $qr = "SELECT * FROM `sanpham` inner join `anh` on sanpham.MaAnh = anh.MaAnh inner join`loaiSP` on sanpham.maLoai = loaiSP.maLoai inner join`nhasx` on nhasx.maNSX = sanpham.maNSX where nhasx.maNSX = $id ";
        return $this->conn->query($qr);
    }
    function getlistproductsp($id, $masp)
    {

        $qr = "SELECT * FROM `sanpham` inner join `anh` on sanpham.MaAnh = anh.MaAnh inner join`loaiSP` on sanpham.maLoai = loaiSP.maLoai inner join`nhasx` on nhasx.maNSX = sanpham.maNSX where nhasx.maNSX = $id and loaiSP.maLoai = $masp ";
        return $this->conn->query($qr);
    }
}
