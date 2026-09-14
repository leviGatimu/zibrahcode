<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE comments
            ADD COLUMN is_pinned TINYINT(1) NOT NULL DEFAULT 0,
            ADD COLUMN is_liked_by_admin TINYINT(1) NOT NULL DEFAULT 0'
    );
};
