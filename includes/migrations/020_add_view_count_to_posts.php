<?php
return function (PDO $pdo) {
    $pdo->exec('ALTER TABLE posts ADD COLUMN view_count INT UNSIGNED NOT NULL DEFAULT 0');
};
