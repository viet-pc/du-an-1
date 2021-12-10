<?php

class homemodel extends database
{
    function getsv()
    {
        $qr = "SELECT * FROM `sanpham`,`anh` WHERE sanpham.MaAnh = anh.MaAnh LIMIT 0,6";
        return $this->conn->query($qr);
    }
    function getLoaiSP()
    {
        $qr = "SELECT * FROM `loaisp` ";
        return $this->conn->query($qr);
    }
    function getNhaSX()
    {
        $qr = "SELECT * FROM `nhasx` ";
        return $this->conn->query($qr);
    }
}
