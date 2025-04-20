<?php
require_once(__DIR__ . '/../../config/db.php');

$database = new Database();
$pdo = $database->conn;

// Get search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE title LIKE :search OR director LIKE :search");
        $stmt->execute([':search' => "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM movies");
    }
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h2>Movie List</h2>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <form class="d-flex" method="GET">
                <input type="hidden" name="page" value="movie">
                <input class="form-control me-2" type="search" 
                       placeholder="Search title or director" 
                       name="search" 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-primary" type="submit">Search</button>
                <?php if(!empty($search)): ?>
                    <a href="?page=movie" class="btn btn-outline-secondary ms-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="?page=movie&action=add" class="btn btn-success">Add New Movie</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Release Year</th>
                <th>Director</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($movies)): ?>
                <?php foreach($movies as $movie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($movie['id_movie']); ?></td>
                    <td><?php echo htmlspecialchars($movie['title']); ?></td>
                    <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                    <td><?php echo htmlspecialchars($movie['release_year']); ?></td>
                    <td><?php echo htmlspecialchars($movie['director']); ?></td>
                    <td>
                        <a href="?page=movie&action=edit&id=<?php echo $movie['id_movie']; ?>" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="?page=movie&action=delete&id=<?php echo $movie['id_movie']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this movie?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No movies found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>