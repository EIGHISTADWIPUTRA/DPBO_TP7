<?php
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$id_review = isset($_GET['id']) ? $_GET['id'] : null;

// Get users and movies for dropdowns
try {
    $users = $pdo->query("SELECT id_user, username FROM users ORDER BY username")->fetchAll();
    $movies = $pdo->query("SELECT id_movie, title FROM movies ORDER BY title")->fetchAll();
    
    // Get current review data
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id_review = ?");
    $stmt->execute([$id_review]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$review) {
        echo "Review not found";
        exit;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE reviews SET 
                id_user = :id_user,
                id_movie = :id_movie,
                rating = :rating,
                comment = :comment
                WHERE id_review = :id_review";
                
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':id_user' => $_POST['id_user'],
            ':id_movie' => $_POST['id_movie'],
            ':rating' => $_POST['rating'],
            ':comment' => $_POST['comment'],
            ':id_review' => $id_review
        ]);

        $_SESSION['message'] = "Review successfully updated";
        $_SESSION['message_type'] = "success";
        
        header('Location: index.php?page=review');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <h2>Edit Review</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="id_user" class="form-label">User</label>
            <select class="form-select" id="id_user" name="id_user" required>
                <option value="">Select User</option>
                <?php foreach($users as $user): ?>
                    <option value="<?php echo $user['id_user']; ?>" 
                            <?php echo ($user['id_user'] == $review['id_user']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="id_movie" class="form-label">Movie</label>
            <select class="form-select" id="id_movie" name="id_movie" required>
                <option value="">Select Movie</option>
                <?php foreach($movies as $movie): ?>
                    <option value="<?php echo $movie['id_movie']; ?>"
                            <?php echo ($movie['id_movie'] == $review['id_movie']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($movie['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <input type="number" class="form-control" id="rating" name="rating" 
                   value="<?php echo htmlspecialchars($review['rating']); ?>"
                   min="1" max="10" required>
        </div>
        
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" required><?php 
                echo htmlspecialchars($review['comment']); 
            ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Review</button>
        <a href="?page=review" class="btn btn-secondary">Cancel</a>
    </form>
</div>