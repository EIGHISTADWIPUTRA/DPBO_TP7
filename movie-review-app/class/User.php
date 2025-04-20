<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $email) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
        return $stmt->execute([$username, $email]);
    }

    public function updateUser($id, $username, $email) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ? WHERE id_user = ?");
        return $stmt->execute([$username, $email, $id]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
        return $stmt->execute([$id]);
    }
}
?>