<?php
class loginmodel extends database
{
    function getUP()
    {
        $qr = "SELECT * FROM khachhang";
        return $this->conn->query($qr);
    }
}
