<?php
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :search OR email LIKE :search");
        $stmt->execute([':search' => "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM users");
    }
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">';
    echo $_SESSION['message'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

?>

<div class="container mt-4">
    <h2>User List</h2>
    
    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form class="d-flex" method="GET">
                <input type="hidden" name="page" value="user">
                <input class="form-control me-2" type="search" 
                       placeholder="Search username or email" 
                       name="search" 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-primary" type="submit">Search</button>
                <?php if(!empty($search)): ?>
                    <a href="?page=user" class="btn btn-outline-secondary ms-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="?page=user&action=add" class="btn btn-success">Add New User</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id_user']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['registered_at']); ?></td>
                    <td>
                        <a href="?page=user&action=edit&id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?page=user&action=delete&id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin dek?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php if (!empty($search) && empty($users)): ?>
        <div class="alert alert-info">
            No users found matching "<?php echo htmlspecialchars($search); ?>"
        </div>
    <?php endif; ?>
</div>
