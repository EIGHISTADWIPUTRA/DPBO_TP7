<?php
session_start();
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$id_movie = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_movie) {
    try {
        $check = $pdo->prepare("SELECT id_movie FROM movies WHERE id_movie = ?");
        $check->execute([$id_movie]);
        
        if ($check->rowCount() > 0) {
            $stmt = $pdo->prepare("DELETE FROM movies WHERE id_movie = ?");
            $stmt->execute([$id_movie]);
            
            $_SESSION['message'] = "Movie successfully deleted";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Movie not found";
            $_SESSION['message_type'] = "danger";
        }
    } catch(PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
}

header('Location: index.php?page=movie');
exit;