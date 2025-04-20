<?php
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

$id_movie = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE movies SET 
                title = :title, 
                genre = :genre, 
                release_year = :release_year, 
                director = :director 
                WHERE id_movie = :id_movie";
                
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':title' => $_POST['title'],
            ':genre' => $_POST['genre'],
            ':release_year' => $_POST['release_year'],
            ':director' => $_POST['director'],
            ':id_movie' => $id_movie
        ]);

        $_SESSION['message'] = "Movie successfully updated";
        $_SESSION['message_type'] = "success";
        
        header('Location: index.php?page=movie');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE id_movie = ?");
    $stmt->execute([$id_movie]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$movie) {
        echo "Movie not found";
        exit;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Movie</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" 
                   value="<?php echo htmlspecialchars($movie['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" 
                   value="<?php echo htmlspecialchars($movie['genre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="release_year" class="form-label">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" 
                   value="<?php echo htmlspecialchars($movie['release_year']); ?>" 
                   min="1900" max="<?php echo date('Y'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="director" class="form-label">Director</label>
            <input type="text" class="form-control" id="director" name="director" 
                   value="<?php echo htmlspecialchars($movie['director']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="?page=movie" class="btn btn-secondary">Cancel</a>
    </form>
</div>