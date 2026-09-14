<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE posts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            excerpt TEXT NULL,
            body LONGTEXT NOT NULL,
            featured_image_path VARCHAR(255) NULL,
            category VARCHAR(100) NULL,
            status ENUM("draft","published") DEFAULT "draft",
            published_at DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL,
            author_name VARCHAR(100) DEFAULT "Ibrahim Ngugi",
            meta_description VARCHAR(300) NULL,
            legacy_slug VARCHAR(255) NULL,
            INDEX idx_status_published (status, published_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
