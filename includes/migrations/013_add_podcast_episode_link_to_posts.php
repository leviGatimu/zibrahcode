<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE posts
            ADD COLUMN podcast_episode_id INT UNSIGNED NULL AFTER category,
            ADD FOREIGN KEY (podcast_episode_id) REFERENCES podcast_episodes(id) ON DELETE SET NULL'
    );
};
