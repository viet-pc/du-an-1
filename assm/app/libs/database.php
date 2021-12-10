<?php
class database
{
    public $conn;
    protected $host = "localhost";
    protected $name = "root";
    protected $password = "";
    protected $database = "asm";

    function __construct()
    {
        // $this->conn = mysqli_connect($this->host, $this->name, $this->password);
        // mysqli_select_db($this->conn, $this->database);
        // mysqli_query($this->conn, "SET NAMES 'utf8'");
        // if ($this->conn->connect_errno) {
        //     echo 'kết nối lỗi';
        // }
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->name, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // echo "Kết nối lỗi: " . $e->getMessage();
        }
    }
}
