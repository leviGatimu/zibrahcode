<?php
/**
 * Bot protection for the public forms (contact, inquire, newsletter).
 *
 * Automated submissions were arriving in volume, all of them passing the
 * existing checks — a bot that loads the page gets a session and a CSRF token
 * like anyone else. This layers four cheap, key-free tests that bots fail and
 * people don't notice:
 *
 *   1. Honeypot — a text input hidden from sighted users, screen readers and
 *      the tab order. Form-fillers populate every field they find.
 *   2. Timing — the form carries a signed timestamp of when it was rendered.
 *      A submission arriving under SPAM_GUARD_MIN_SECONDS later was not typed
 *      by a person; one older than a day is a replayed token.
 *   3. Link density — more than a couple of URLs in a contact message is the
 *      signature of link-drop spam.
 *   4. Rate limit — a cap on submissions per form per IP address, so a single
 *      source can never flood an inbox no matter how it dodges the rest.
 *
 * Usage: echo spamGuardFields() inside the <form>, then in the handler call
 * spamGuardCheck() after basic validation and act on the reason it returns.
 */

const SPAM_GUARD_MIN_SECONDS = 3;
const SPAM_GUARD_MAX_SECONDS = 86400;

/** Honeypot input + signed render timestamp. Hidden via .spam-guard-field in style.css. */
function spamGuardFields(): string
{
    static $instance = 0;
    $instance++;
    $id = 'sg-website-' . $instance;

    $issued = time();
    $signature = hash_hmac('sha256', 'form-issued:' . $issued, APP_SECRET);

    return '<div class="spam-guard-field" aria-hidden="true">'
        . '<label for="' . $id . '">Leave this field empty</label>'
        . '<input type="text" name="website" id="' . $id . '" tabindex="-1" autocomplete="off" value="">'
        . '</div>'
        . '<input type="hidden" name="form_issued" value="' . $issued . '.' . $signature . '">';
}

/**
 * Inspects the current POST for the tell-tale signs of automation.
 *
 * @param string   $form       Short form name used to bucket the rate limit ("contact").
 * @param string[] $textFields Free-text values to scan for links.
 * @param array    $options    'max_per_window' (default 3), 'window_seconds' (default 900), 'max_links' (default 2).
 * @return string|null null when the submission looks human, otherwise a reason:
 *   'rate-limit' (tell the user to wait), 'honeypot', 'timing' or 'links'.
 */
function spamGuardCheck(string $form, array $textFields = [], array $options = []): ?string
{
    $maxPerWindow = (int) ($options['max_per_window'] ?? 3);
    $windowSeconds = (int) ($options['window_seconds'] ?? 900);
    $maxLinks = (int) ($options['max_links'] ?? 2);

    // Rate limit first: it is the one check that must keep counting even when
    // the other checks already flagged the request, or a flood of flagged
    // requests would still cost a database insert each.
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    if (spamGuardRateLimited($form . ':' . $ip, $maxPerWindow, $windowSeconds)) {
        return 'rate-limit';
    }

    if (($_POST['website'] ?? '') !== '') {
        return 'honeypot';
    }

    $issued = (string) ($_POST['form_issued'] ?? '');
    if (!spamGuardTimingValid($issued)) {
        return 'timing';
    }

    $linkCount = 0;
    foreach ($textFields as $text) {
        $linkCount += preg_match_all('~https?://|www\.|\[url[=\]]|<a\s~i', (string) $text);
    }
    if ($linkCount > $maxLinks) {
        return 'links';
    }

    return null;
}

function spamGuardTimingValid(string $issued): bool
{
    $parts = explode('.', $issued, 2);
    if (count($parts) !== 2 || !ctype_digit($parts[0])) {
        return false;
    }
    $expected = hash_hmac('sha256', 'form-issued:' . $parts[0], APP_SECRET);
    if (!hash_equals($expected, $parts[1])) {
        return false;
    }
    $elapsed = time() - (int) $parts[0];
    return $elapsed >= SPAM_GUARD_MIN_SECONDS && $elapsed <= SPAM_GUARD_MAX_SECONDS;
}

/**
 * Records one hit for $bucket and reports whether the bucket had already
 * reached its cap within the window. Old rows are pruned opportunistically
 * (about one request in fifty) so the table never grows unbounded.
 */
function spamGuardRateLimited(string $bucket, int $max, int $windowSeconds): bool
{
    $db = getDb();
    $count = $db->prepare('SELECT COUNT(*) FROM rate_limit_hits WHERE bucket = ? AND hit_at > (NOW() - INTERVAL ? SECOND)');
    $count->execute([$bucket, $windowSeconds]);
    $hits = (int) $count->fetchColumn();

    $db->prepare('INSERT INTO rate_limit_hits (bucket, hit_at) VALUES (?, NOW())')->execute([$bucket]);

    if (random_int(1, 50) === 1) {
        $db->exec('DELETE FROM rate_limit_hits WHERE hit_at < (NOW() - INTERVAL 1 DAY)');
    }

    return $hits >= $max;
}
