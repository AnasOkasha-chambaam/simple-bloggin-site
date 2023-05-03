<?php
namespace Project\Config;

use PDO;
use PDOException;

class Database {
  private $host = 'localhost';
  private $db_name = 'myblog';
  private $username = 'root';
  private $password = 'mypassword';
  private $conn;

  public function getConnection() {
    $this->conn = null;

    try {
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $exception) {
      echo 'Connection Error: ' . $exception->getMessage();
    }

    return $this->conn;
  }
}