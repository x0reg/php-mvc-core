<?php
require_once(__DIR__ . "/Init.php");
class ConnectionDB
{
    public $pdo;

    public function __construct()
    {
        // Thông tin kết nối database
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        // Tạo kết nối PDO
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Kết Nối CSDL Thất Bại: " . $e->getMessage();
            die();
        }
    }
}
