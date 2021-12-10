<?php
class regitermodel extends database
{
    function getkh()
    {
        $qr = "SELECT * FROM khachhang";
        return $this->conn->query($qr);
    }
    function insertkh($hvt, $sdt, $email, $tdn, $pass, $dc)
    {
        //$qr = "INSERT INTO `khachhang`( `HoTen`, `DiaChi`, `SoDT`, `Email`, `username`, `password`) VALUES ('$data["hvt"]','$data["dc"]','$data["sdt"]','$data["email"]','$data["tdn"]','$data["pass"]')";
        $qr = "INSERT INTO  `khachhang`( `HoTen`, `DiaChi`, `SoDT`, `Email`, `username`, `password`) VALUES ('$hvt','$dc', '$sdt','$email','$tdn','$pass')";
        return $this->conn->exec($qr);
    }
    function updatekh($id, $hvt, $sdt, $email, $tdn, $pass, $dc)
    {
        $qr = 'UPDATE `khachhang` SET `HoTen`=' . $hvt . ',`DiaChi`=' . $dc . ',`SoDT`=' . $sdt . ',`Email`=' . $email . ',`username`=' . $tdn . ',`password`=' . $pass . ' WHERE `MaKH`=' . $id . '';
        return $this->conn->exec($qr);
    }
    function xoakh($id)
    {
        $qr = "DELETE FROM `khachhang` WHERE `khachhang`.`MaKH` = $id";
        return $this->conn->query($qr);
    }
}
