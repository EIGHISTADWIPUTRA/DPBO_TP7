<?php
session_start();
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$id_user = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_user) {
    try {

        $check = $pdo->prepare("SELECT id_user FROM users WHERE id_user = ?");
        $check->execute([$id_user]);
        
        if ($check->rowCount() > 0) {

            $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
            $stmt->execute([$id_user]);
            
            $_SESSION['message'] = "User berhasil dihapus";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "User tidak ditemukan";
            $_SESSION['message_type'] = "danger";
        }
    } catch(PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
}

header('Location: ?page=user');
exit;