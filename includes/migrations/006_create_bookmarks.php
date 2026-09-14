<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE bookmarks (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            bookmarkable_type ENUM("post","episode") NOT NULL,
            bookmarkable_id INT UNSIGNED NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_bookmark (user_id, bookmarkable_type, bookmarkable_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
