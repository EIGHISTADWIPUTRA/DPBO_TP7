<?php
require_once(__DIR__ . '/../../config/db.php');


$database = new Database();
$pdo = $database->conn;

$id_user = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id_user = :id_user";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':username' => $_POST['username'],
            ':email' => $_POST['email'],
            ':id_user' => $id_user
        ]);

        header('Location: ?page=user');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}


try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
    $stmt->execute([$id_user]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "User tidak ditemukan";
        exit;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="?page=user" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</div>    </form>    </form>
</div>
