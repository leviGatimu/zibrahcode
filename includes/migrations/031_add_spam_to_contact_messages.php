<?php
/**
 * Spam handling for contact messages.
 *
 * "spam" joins the existing status enum rather than becoming a separate flag,
 * because a message is exactly one of these things at a time — a spam message
 * is not also "new" or "archived". Reusing the column keeps every existing
 * query (dashboard counts, the admin list) correct without modification.
 *
 * spam_marked_at records *when* it was flagged, so the admin list can say when
 * it will be purged and the nightly job can report what it removed.
 */
return function (PDO $pdo) {
    $pdo->exec(
        'ALTER TABLE contact_messages
            MODIFY COLUMN status ENUM("new","read","archived","spam") NOT NULL DEFAULT "new"'
    );
    $pdo->exec('ALTER TABLE contact_messages ADD COLUMN spam_marked_at DATETIME NULL');
    $pdo->exec('ALTER TABLE contact_messages ADD INDEX idx_status (status)');
};
