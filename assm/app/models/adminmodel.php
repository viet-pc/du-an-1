<?php
class adminmodel extends database
{
    function getsp()
    {
        $qr = "SELECT * FROM `sanpham` INNER JOIN `anh` ON sanpham.MaAnh = anh.MaAnh INNER JOIN `loaiSP` ON loaiSP.MaLoai = sanpham.MaLoai INNER JOIN `nhasx` ON sanpham.MaNSX = nhasx.MaNSX";
        return $this->conn->query($qr);
    }
    function remove($id)
    {
        $sql = "DELETE p, pa FROM anh p JOIN sanpham pa ON pa.MaAnh = p.MaAnh WHERE  pa.MaSP = $id";
        $this->conn->query($sql);
    }
    function getnsx()
    {
        $sql = "SELECT * FROM nhasx";
        return $this->conn->query($sql);
    }
    function getloai()
    {
        $sql = "SELECT * FROM loaisp";
        return $this->conn->query($sql);
    }
    function themanhsp($data = [])
    {
        try {
            $keys = implode(",", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO anh($keys) VALUES($values)";
            $query = $this->conn->prepare($sql);
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $query->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            die("Lỗi: " . $e->getMessage());
        };
    }
    function themsp($data = [])
    {
        try {
            $keys = implode(",", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO sanpham($keys) VALUES($values)";
            $query = $this->conn->prepare($sql);
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $query->execute();
        } catch (PDOException $e) {
            die("Lỗi: " . $e->getMessage());
        };
    }
    function update($table, $data = [], $cond)
    {
        $updateKeys = NULL;

        foreach ($data as $key => $value) {
            $updateKeys .= "$key=:$key,";
        }

        $updateKeys = rtrim($updateKeys, ",");

        $sql = "UPDATE $table SET $updateKeys WHERE $cond";
        $statement = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        return $statement->execute();
    }

    function getallbyid($id)
    {
        $qr = "SELECT * FROM `sanpham` INNER JOIN `anh`ON sanpham.MaAnh = anh.MaAnh WHERE  MaSP =  $id";
        $query = $this->conn->prepare($qr);
        $query->execute();
        return $query->fetch();
    }
    function getallkhbyid($id)
    {
        $qr = "SELECT * FROM `khachhang`  WHERE  MaKH =  $id";
        $query = $this->conn->prepare($qr);
        $query->execute();
        return $query->fetch();
    }
    function getkh()
    {
        $sql = "SELECT * FROM khachhang";
        return $this->conn->query($sql);
    }
    function ktu($u)
    {
        $sql = "SELECT username FROM admin WHERE username='{$u}'";
        return  $this->conn->query($sql);
    }
    function ktp($u, $p)
    {
        $sql = "SELECT username FROM admin WHERE username='{$u}' AND pass = '{$p}'";
        return  $this->conn->query($sql);
    }
}
