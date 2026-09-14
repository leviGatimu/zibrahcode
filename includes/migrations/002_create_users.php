<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            avatar_path VARCHAR(255) NULL,
            newsletter_opt_in TINYINT(1) DEFAULT 1,
            status ENUM("active","suspended") DEFAULT "active",
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
