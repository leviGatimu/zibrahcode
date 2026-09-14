<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE podcast_episodes ADD COLUMN meta_description VARCHAR(300) NULL AFTER description'
    );
};
