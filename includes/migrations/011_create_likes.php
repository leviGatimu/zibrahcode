<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE likes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            likeable_type ENUM("post","episode") NOT NULL,
            likeable_id INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_like (user_id, likeable_type, likeable_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
