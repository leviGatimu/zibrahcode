<?php
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE login_attempts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            identifier VARCHAR(190) NOT NULL,
            attempted_at DATETIME NOT NULL,
            INDEX (identifier, attempted_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
