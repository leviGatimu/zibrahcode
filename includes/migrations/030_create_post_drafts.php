<?php
/**
 * Autosave storage for the post editor.
 *
 * Deliberately a separate table rather than writing into `posts` directly:
 * autosaving an in-progress edit straight into a published post would push
 * half-finished paragraphs live to readers every twenty seconds.
 *
 * post_id = 0 is the draft of a not-yet-created post, so an author who types
 * for hours on a brand-new article is protected from the very first keystroke.
 * One draft per (admin, post) — the newest keystrokes always win.
 */
return function (PDO $pdo) {
    $pdo->exec(
        'CREATE TABLE post_drafts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            admin_id INT UNSIGNED NOT NULL,
            post_id INT UNSIGNED NOT NULL DEFAULT 0,
            title VARCHAR(255) NULL,
            slug VARCHAR(255) NULL,
            excerpt TEXT NULL,
            body LONGTEXT NULL,
            category VARCHAR(100) NULL,
            meta_description VARCHAR(300) NULL,
            status VARCHAR(20) NULL,
            podcast_episode_id INT UNSIGNED NULL,
            updated_at DATETIME NOT NULL,
            UNIQUE KEY uniq_admin_post (admin_id, post_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};
