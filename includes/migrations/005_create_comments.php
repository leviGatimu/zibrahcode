<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE comments (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            commentable_type ENUM("post","episode") NOT NULL,
            commentable_id INT UNSIGNED NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            body TEXT NOT NULL,
            status ENUM("visible","deleted") DEFAULT "visible",
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_commentable (commentable_type, commentable_id, status),
            INDEX idx_user (user_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
