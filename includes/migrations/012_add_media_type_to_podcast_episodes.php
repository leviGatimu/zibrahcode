<?php
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE podcast_episodes
            MODIFY audio_file_path VARCHAR(255) NULL,
            ADD COLUMN media_type ENUM("audio","video") NOT NULL DEFAULT "audio" AFTER audio_file_path,
            ADD COLUMN video_file_path VARCHAR(255) NULL AFTER media_type'
    );
};
