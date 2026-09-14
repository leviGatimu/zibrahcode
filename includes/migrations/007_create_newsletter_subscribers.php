<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE newsletter_subscribers (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            name VARCHAR(100) NULL,
            user_id INT UNSIGNED NULL,
            status ENUM("subscribed","unsubscribed") DEFAULT "subscribed",
            source VARCHAR(50) NULL,
            subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            unsubscribed_at DATETIME NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
