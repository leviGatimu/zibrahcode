<?php
/**
 * Deletes every contact message flagged as spam. Scheduled to run daily at noon.
 *
 * Run it from cron as a shell command (preferred):
 *     /usr/local/bin/php /home/ybeqkcet/public_html/cron/purge-spam-messages.php
 *
 * Some hosts can only fetch a URL on a schedule. That works too, but the
 * request must carry a token derived from APP_SECRET — otherwise anyone who
 * guessed the path could destroy the spam queue before it had been reviewed.
 *
 * Deliberately does NOT include bootstrap.php: that starts a session, sets
 * cookies and emits security headers, none of which make sense for a scheduled
 * job. config.php + db.php are all this needs, and getDb() still applies any
 * pending migrations, so the job is safe to schedule before the first deploy.
 */

$isCli = PHP_SAPI === 'cli';

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

if (!$isCli) {
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');

    $expected = hash_hmac('sha256', 'purge-spam-messages', APP_SECRET);
    $given = $_GET['token'] ?? '';

    if (!is_string($given) || $given === '' || !hash_equals($expected, $given)) {
        http_response_code(403);
        echo "Forbidden\n";
        exit(1);
    }
}

try {
    $db = getDb();

    $count = (int) $db->query('SELECT COUNT(*) FROM contact_messages WHERE status = "spam"')->fetchColumn();
    if ($count > 0) {
        $db->exec('DELETE FROM contact_messages WHERE status = "spam"');
    }

    $summary = sprintf(
        'purge-spam-messages: deleted %d spam message%s at %s',
        $count,
        $count === 1 ? '' : 's',
        date('Y-m-d H:i:s T')
    );

    // Under cron the printed line IS the record — cron mails stdout to the
    // account owner. error_log() would only duplicate it, because CLI ignores
    // .user.ini and falls back to stderr. Over HTTP nobody is reading the
    // response, so there the site log is the only durable trace.
    if (!$isCli) {
        error_log($summary);
    }
    echo $summary, "\n";
    exit(0);
} catch (Throwable $e) {
    $failure = 'purge-spam-messages FAILED: ' . $e->getMessage();
    if (!$isCli) {
        error_log($failure);
    }

    if ($isCli) {
        fwrite(STDERR, $failure . "\n");
    } else {
        http_response_code(500);
        echo $failure, "\n";
    }
    exit(1);
}
