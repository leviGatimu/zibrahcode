<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE likes
            MODIFY user_id INT UNSIGNED NULL,
            ADD COLUMN guest_token VARCHAR(64) NULL AFTER user_id,
            MODIFY likeable_type ENUM("post","episode","comment") NOT NULL,
            ADD UNIQUE KEY uniq_like_guest (guest_token, likeable_type, likeable_id)'
    );
};
