<?php
require_once __DIR__ . '/../config/db.php';

class Review {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllReviews() {
        $stmt = $this->db->query("SELECT r.*, u.username, m.title 
                                   FROM reviews r
                                   JOIN users u ON r.id_user = u.id_user
                                   JOIN movies m ON r.id_movie = m.id_movie");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewById($id) {
        $stmt = $this->db->prepare("SELECT * FROM reviews WHERE id_review = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReview($id_user, $id_movie, $rating, $comment) {
        $stmt = $this->db->prepare("INSERT INTO reviews (id_user, id_movie, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_user, $id_movie, $rating, $comment]);
    }

    public function updateReview($id, $id_user, $id_movie, $rating, $comment) {
        $stmt = $this->db->prepare("UPDATE reviews SET id_user = ?, id_movie = ?, rating = ?, comment = ? WHERE id_review = ?");
        return $stmt->execute([$id_user, $id_movie, $rating, $comment, $id]);
    }

    public function deleteReview($id) {
        $stmt = $this->db->prepare("DELETE FROM reviews WHERE id_review = ?");
        return $stmt->execute([$id]);
    }

    public function searchReviewByMovieTitle($keyword) {
        $stmt = $this->db->prepare("SELECT r.*, u.username, m.title 
                                     FROM reviews r
                                     JOIN users u ON r.id_user = u.id_user
                                     JOIN movies m ON r.id_movie = m.id_movie
                                     WHERE m.title LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>