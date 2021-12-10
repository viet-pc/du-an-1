<?php

class detailmodel extends database
{
    function getallbyid($id)
    {
        $qr = "SELECT * FROM `sanpham` INNER JOIN `anh`ON sanpham.MaAnh = anh.MaAnh WHERE  MaSP =  $id";
        $query = $this->conn->prepare($qr);
        $query->execute();
        return $query->fetch();
    }
    function increaseviews($id)
    {
        $sql = "UPDATE sanpham SET views = views+1 WHERE  maSP=$id";
        return $this->conn->query($sql);
    }
}
