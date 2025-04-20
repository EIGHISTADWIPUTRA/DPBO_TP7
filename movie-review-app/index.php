<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Lantur Review</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'user') ? 'active' : ''; ?>" 
                           href="?page=user">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'movie') ? 'active' : ''; ?>" 
                           href="?page=movie">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'review') ? 'active' : ''; ?>" 
                           href="?page=review">Reviews</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
 
            if ($page == 'user') {
               
                $action = $_GET['action'] ?? null;
                if ($action == 'edit') {
                    include 'view/user/edit.php';
                } elseif ($action == 'show') {
                    include 'view/user/show.php';
                } elseif ($action == 'delete') {
                    include 'view/user/delete.php';
                } elseif ($action == 'add') { 
                    include 'view/user/add.php';
                } else {
                    include 'view/user/index.php';
                }
            }
            
            elseif ($page == 'movie') {
                $action = $_GET['action'] ?? null;
                if ($action == 'edit') {
                    include 'view/movie/edit.php';
                } elseif ($action == 'delete') {
                    include 'view/movie/delete.php';
                } elseif ($action == 'add') {
                    include 'view/movie/add.php';
                } else {
                    include 'view/movie/index.php';
                }
            }
           
            elseif ($page == 'review') {
                $action = $_GET['action'] ?? null;
                if ($action == 'edit') {
                    include 'view/review/edit.php';
                } elseif ($action == 'delete') {
                    include 'view/review/delete.php';
                } elseif ($action == 'add') {
                    include 'view/review/add.php';
                } else {
                    include 'view/review/index.php';
                }
            }
        }
        ?>
    </main>

    <!-- Add Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
