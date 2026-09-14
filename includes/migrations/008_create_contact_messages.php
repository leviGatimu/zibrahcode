<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE contact_messages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NULL,
            message TEXT NOT NULL,
            status ENUM("new","read","archived") DEFAULT "new",
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            ip_address VARCHAR(45) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
