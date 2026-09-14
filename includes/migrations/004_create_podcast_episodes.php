<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE podcast_episodes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT NULL,
            show_notes LONGTEXT NULL,
            audio_file_path VARCHAR(255) NOT NULL,
            audio_duration_seconds INT UNSIGNED NULL,
            cover_image_path VARCHAR(255) NULL,
            episode_number INT UNSIGNED NULL,
            season_number INT UNSIGNED DEFAULT 1,
            status ENUM("draft","published") DEFAULT "draft",
            published_at DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL,
            INDEX idx_status_published (status, published_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
