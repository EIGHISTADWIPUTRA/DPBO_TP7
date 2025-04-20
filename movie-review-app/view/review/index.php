<?php
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

try {
    $stmt = $pdo->query("SELECT r.*, u.username, m.title 
                         FROM reviews r 
                         JOIN users u ON r.id_user = u.id_user 
                         JOIN movies m ON r.id_movie = m.id_movie 
                         ORDER BY r.review_date DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Display feedback message
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
    <h2>Review List</h2>
    
    <div class="mb-3 text-end">
        <a href="?page=review&action=add" class="btn btn-success">Add New Review</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Review Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reviews)): ?>
                <?php foreach($reviews as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['id_review']); ?></td>
                    <td><?php echo htmlspecialchars($review['username']); ?></td>
                    <td><?php echo htmlspecialchars($review['title']); ?></td>
                    <td><?php echo htmlspecialchars($review['rating']); ?>/10</td>
                    <td><?php echo htmlspecialchars($review['comment']); ?></td>
                    <td><?php echo htmlspecialchars($review['review_date']); ?></td>
                    <td>
                        <a href="?page=review&action=edit&id=<?php echo $review['id_review']; ?>" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="?page=review&action=delete&id=<?php echo $review['id_review']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No reviews found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>