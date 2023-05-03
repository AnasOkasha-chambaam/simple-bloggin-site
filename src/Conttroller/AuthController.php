<?php

namespace App\Controller;

use App\Model\User;
use App\Config\Database;

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function register($name, $email, $password)
    {
        $hashedPassword = sha1($password);

        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $result = $stmt->execute();

        if (!$result) {
            die("Error creating user: " . $this->db->error);
        }

        return $stmt->insert_id;
    }

    public function login($email, $password)
    {
        $hashedPassword = sha1($password);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        $user = new User($result->fetch_assoc());

        return $user;
    }

    public function getCurrentUser()
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $userId = $_SESSION['user_id'];

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        $user = new User($result->fetch_assoc());

        return $user;
    }
}