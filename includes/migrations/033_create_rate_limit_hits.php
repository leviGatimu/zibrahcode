<?php
/**
 * Per-IP submission counter behind includes/spam-guard.php. One row per
 * public-form submission; rows older than a day are pruned by the guard itself.
 */
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE rate_limit_hits (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            bucket VARCHAR(190) NOT NULL,
            hit_at DATETIME NOT NULL,
            INDEX idx_bucket_time (bucket, hit_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
