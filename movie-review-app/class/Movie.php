<?php
require_once __DIR__ . '/../config/db.php';

class Movie {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllMovies() {
        $stmt = $this->db->query("SELECT * FROM movies");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovieById($id) {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function searchMovies($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE title LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMovie($title, $genre, $release_year, $director) {
        $stmt = $this->db->prepare("INSERT INTO movies (title, genre, release_year, director) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $genre, $release_year, $director]);
    }

    public function updateMovie($id, $title, $genre, $release_year, $director) {
        $stmt = $this->db->prepare("UPDATE movies SET title = ?, genre = ?, release_year = ?, director = ? WHERE id_movie = ?");
        return $stmt->execute([$title, $genre, $release_year, $director, $id]);
    }

    public function deleteMovie($id) {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id_movie = ?");
        return $stmt->execute([$id]);
    }
}
?>