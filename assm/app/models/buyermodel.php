<?php
class buyermodel extends database
{
    function getUP()
    {
        $qr = "SELECT * FROM khachhang";
        return $this->conn->query($qr);
    }
    function checkpass($u, $pass_old)
    {
        $sql = "SELECT count(*) FROM khachhang WHERE username=:username and password =:pass_old";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':username', $u);
        $query->bindParam(':pass_old', $pass_old);
        $query->execute();
        return  $query->fetch();
    }
    function updatepass($pass_new1, $u)
    {
        $sql = "UPDATE khachhang SET password ='{$pass_new1}'WHERE username='{$u}'";

        return $this->conn->exec($sql);
    }
}
