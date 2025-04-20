<?php
session_start();
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "INSERT INTO movies (title, genre, release_year, director) 
                VALUES (:title, :genre, :release_year, :director)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':title' => $_POST['title'],
            ':genre' => $_POST['genre'],
            ':release_year' => $_POST['release_year'],
            ':director' => $_POST['director']
        ]);

        $_SESSION['message'] = "Movie successfully added";
        $_SESSION['message_type'] = "success";
        
        header('Location: index.php?page=movie');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <h2>Add New Movie</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="mb-3">
            <label for="release_year" class="form-label">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" 
                   min="1900" max="<?php echo date('Y'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="director" class="form-label">Director</label>
            <input type="text" class="form-control" id="director" name="director" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Movie</button>
        <a href="?page=movie" class="btn btn-secondary">Cancel</a>
    </form>
</div>