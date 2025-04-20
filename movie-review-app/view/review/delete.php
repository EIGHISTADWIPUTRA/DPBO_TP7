<?php
session_start();
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$id_review = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_review) {
    try {
        $check = $pdo->prepare("SELECT id_review FROM reviews WHERE id_review = ?");
        $check->execute([$id_review]);
        
        if ($check->rowCount() > 0) {
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id_review = ?");
            $stmt->execute([$id_review]);
            
            $_SESSION['message'] = "Review successfully deleted";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Review not found";
            $_SESSION['message_type'] = "danger";
        }
    } catch(PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
}

header('Location: index.php?page=review');
exit;