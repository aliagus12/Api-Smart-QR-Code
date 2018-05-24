<?php

/**
 * Created by PhpStorm.
 * User: ali
 * Date: 21/05/18
 * Time: 16.11
 */
class Database
{
// specify your own database credentials
    public $conn;
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";

// get the database connection

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOExeption $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

