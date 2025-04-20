CREATE DATABASE IF NOT EXISTS db_moviereview;
USE db_moviereview;

-- Users table
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Movies table
CREATE TABLE movies (
    id_movie INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    release_year INT,
    director VARCHAR(100)
);

-- Reviews table
CREATE TABLE reviews (
    id_review INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_movie INT,
    rating INT CHECK (rating >= 1 AND rating <= 10),
    comment TEXT,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_movie) REFERENCES movies(id_movie) ON DELETE CASCADE
);