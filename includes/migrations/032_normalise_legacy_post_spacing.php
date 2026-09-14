<?php
/**
 * One-time content fix that accompanies the "render posts exactly as the
 * editor shows them" change in style.css (.article-body).
 *
 * Until now post.php added a 2rem gap between every block in a post body
 * (Tailwind's space-y-8). The Quill editor never showed that gap: there, each
 * <p> sits flush against the next and a blank line is an explicit <p><br></p>.
 * Authors writing verse (one <p> per line) saw a tight poem in the editor and
 * a double-spaced one on the site. The CSS now matches the editor.
 *
 * That leaves the prose posts written under the old behaviour, which relied on
 * the automatic gap and contain no blank lines of their own. Rendered the new
 * way they would collapse into one unbroken wall of text. This migration
 * inserts the blank line those posts always implied, so they look on the site
 * the way they did yesterday and, from now on, the same way in the editor.
 *
 * Telling prose apart from verse: prose paragraphs are long (the shortest
 * average across the existing prose posts is ~140 characters), verse lines are
 * short (~19 on average). A post whose non-blank paragraphs average under
 * PROSE_MIN_AVG_CHARS is treated as verse and left untouched — it already
 * carries its own blank lines and is precisely the content this change fixes.
 *
 * Autosaved drafts get the same treatment so the editor's "recovered draft"
 * comparison doesn't flag every migrated post as having a newer draft.
 */

const PROSE_MIN_AVG_CHARS = 60;

/**
 * Returns the converted body, or null when the body should be left alone
 * (verse, a single paragraph, already spaced, or markup this function does
 * not understand well enough to rewrite safely).
 */
function legacyPostSpacingConvert(string $body): ?string
{
    $blockTags = 'p|h[1-6]|blockquote|ol|ul|pre';
    $pattern = '~<(' . $blockTags . ')\b[^>]*>.*?</\1>~is';

    if (!preg_match_all($pattern, $body, $matches, PREG_OFFSET_CAPTURE)) {
        return null;
    }

    // Safety: the body must consist solely of the blocks matched above,
    // separated by nothing but whitespace. Anything else (bare text, <div>s,
    // unclosed tags) means the regex model of this document is wrong, and a
    // rewrite could drop content. Skip rather than guess.
    $cursor = 0;
    $blocks = [];
    foreach ($matches[0] as [$html, $offset]) {
        if (trim(substr($body, $cursor, $offset - $cursor)) !== '') {
            return null;
        }
        $blocks[] = $html;
        $cursor = $offset + strlen($html);
    }
    if (trim(substr($body, $cursor)) !== '') {
        return null;
    }

    $isBlank = static function (string $block): bool {
        $text = strip_tags($block, '<img>');
        $text = str_replace(["\xC2\xA0", '&nbsp;'], ' ', $text);
        return trim($text) === '';
    };

    $textLengths = [];
    $blankCount = 0;
    foreach ($blocks as $block) {
        if ($isBlank($block)) {
            $blankCount++;
            continue;
        }
        $textLengths[] = mb_strlen(trim(html_entity_decode(strip_tags($block), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    if (count($textLengths) < 2) {
        return null;
    }
    if ((array_sum($textLengths) / count($textLengths)) < PROSE_MIN_AVG_CHARS) {
        return null;
    }
    // Already uses blank lines between most paragraphs — nothing to add.
    if ($blankCount >= count($textLengths) - 1) {
        return null;
    }

    $out = [];
    $previousWasContent = false;
    foreach ($blocks as $block) {
        $blank = $isBlank($block);
        if ($previousWasContent && !$blank) {
            $out[] = '<p><br></p>';
        }
        $out[] = $block;
        $previousWasContent = !$blank;
    }
    $converted = implode('', $out);

    return $converted === $body ? null : $converted;
}

return function (PDO $pdo) {
    $convertTable = static function (string $table) use ($pdo): void {
        $rows = $pdo->query("SELECT id, body FROM $table")->fetchAll(PDO::FETCH_ASSOC);
        $update = $pdo->prepare("UPDATE $table SET body = ? WHERE id = ?");
        foreach ($rows as $row) {
            if ($row['body'] === null) {
                continue;
            }
            $converted = legacyPostSpacingConvert((string) $row['body']);
            if ($converted !== null) {
                $update->execute([$converted, $row['id']]);
                error_log(sprintf('032_normalise_legacy_post_spacing: rewrote %s #%d', $table, $row['id']));
            }
        }
    };

    $convertTable('posts');

    // Drafts are a safety net the editor already treats as optional; a missing
    // table must not abort the migration (which would 500 every page).
    try {
        $convertTable('post_drafts');
    } catch (PDOException $e) {
        error_log('032_normalise_legacy_post_spacing: skipped post_drafts — ' . $e->getMessage());
    }
};
