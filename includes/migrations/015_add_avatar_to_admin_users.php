<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE admin_users ADD COLUMN avatar_path VARCHAR(255) NULL AFTER display_name'
    );
};
