<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE appointment_requests (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(40) NULL,
            preferred_date DATE NULL,
            preferred_time VARCHAR(50) NULL,
            topic VARCHAR(255) NULL,
            message TEXT NULL,
            status ENUM("new","contacted","scheduled","closed") DEFAULT "new",
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            ip_address VARCHAR(45) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
