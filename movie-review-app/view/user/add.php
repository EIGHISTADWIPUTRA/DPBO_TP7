<?php
session_start();
require_once(__DIR__ . '/../../config/db.php');

// Inisialisasi koneksi database
$database = new Database();
$pdo = $database->conn;

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "INSERT INTO users (username, email) VALUES (:username, :email)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':username' => $_POST['username'],
            ':email' => $_POST['email']
        ]);

        $_SESSION['message'] = "User berhasil ditambahkan";
        $_SESSION['message_type'] = "success";
        
        header('Location: index.php?page=user');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <h2>Add New User</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Save User</button>
        <a href="?page=user" class="btn btn-secondary">Cancel</a>
    </form>
</div>