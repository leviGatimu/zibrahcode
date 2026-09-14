<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE admin_users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            display_name VARCHAR(100) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            last_login_at DATETIME NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
