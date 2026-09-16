<?php
/**
 * One-time copy fix: the site no longer uses em dashes anywhere in visible
 * text (templates were rewritten in the same change). The two foundational
 * posts seeded by 009 carried dashes in their bodies (as &mdash; entities from
 * the editor) and in their meta descriptions, so they are rewritten here.
 *
 * Each replacement targets an exact phrase rather than the character, so a
 * post the author has since edited is only touched where the original wording
 * still stands. Autosaved drafts get the same treatment so the editor's
 * "recovered draft" comparison doesn't flag a stale copy as newer.
 */
return function (PDO $pdo) {
    $bodyRewrites = [
        'two independent lines &mdash; truth and perception &mdash; set at an angle'
            => 'two independent lines, truth and perception, set at an angle',
        'What happens between them &mdash; the angle &mdash; is where belief actually lives'
            => 'What happens between them, the angle, is where belief actually lives',
        'Neither position is inherently right &mdash; but each is visible'
            => 'Neither position is inherently right, but each is visible',
        'Zibrah Code framework &mdash; how belief forms, how extremes mirror each other, how wisdom differs from projection &mdash; descends'
            => 'Zibrah Code framework (how belief forms, how extremes mirror each other, how wisdom differs from projection) descends',
        'There is usually a moment&mdash;quiet and easy to miss&mdash;when reality'
            => 'There is usually a moment, quiet and easy to miss, when reality',
        'outwardly&mdash;in conflicts, in leaders, in movements&mdash;they'
            => 'outwardly, in conflicts, in leaders, in movements, they',
    ];

    $metaRewrites = [
        'structure of the Zibrah Code model — a visual representation'
            => 'structure of the Zibrah Code model: a visual representation',
        'how belief narrows and locks — and why geometry'
            => 'how belief narrows and locks, and why geometry',
    ];

    $rewriteColumn = static function (string $table, string $column, array $rewrites) use ($pdo): void {
        $rows = $pdo->query("SELECT id, $column AS value FROM $table WHERE $column IS NOT NULL")->fetchAll(PDO::FETCH_ASSOC);
        $update = $pdo->prepare("UPDATE $table SET $column = ? WHERE id = ?");
        foreach ($rows as $row) {
            $converted = strtr($row['value'], $rewrites);
            if ($converted !== $row['value']) {
                $update->execute([$converted, $row['id']]);
            }
        }
    };

    $rewriteColumn('posts', 'body', $bodyRewrites);
    $rewriteColumn('posts', 'meta_description', $metaRewrites);

    try {
        $rewriteColumn('post_drafts', 'body', $bodyRewrites);
    } catch (PDOException $e) {
        error_log('034_remove_dashes_from_seeded_posts: skipped post_drafts, ' . $e->getMessage());
    }
};
