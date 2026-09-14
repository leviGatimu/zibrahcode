<?php
/**
 * Seeds the two articles that previously lived as standalone static files
 * (post-angles.php, post-structure.php) into the new posts table.
 * Runs exactly once, ever — tracked in schema_migrations like any other migration.
 *
 * Note: post-structure.php shipped with head/meta content only and no article
 * body markup at all in the old codebase, so its body below is a new draft
 * written to match its existing title/meta description and the brand's voice —
 * flagged for the client to review/edit via the admin panel.
 */
return function (PDO $pdo) {
    $stmt = $pdo->prepare(
        'INSERT INTO posts (title, slug, excerpt, body, featured_image_path, category, status, published_at, author_name, meta_description, legacy_slug)
         VALUES (:title, :slug, :excerpt, :body, :featured_image_path, :category, "published", :published_at, "Ibrahim Ngugi", :meta_description, :legacy_slug)'
    );

    $stmt->execute([
        'title' => 'Zibrah Code Foundational Structure',
        'slug' => 'zibrah-code-foundational-structure',
        'excerpt' => 'A visual representation of the independent dimensions of truth and perception.',
        'body' => "<p>Every framework needs a shape. Zibrah Code's shape is deliberately simple: two independent lines &mdash; truth and perception &mdash; set at an angle to each other, not stacked, not merged.</p>\n<p>Most models collapse truth and perception into a single axis, as if believing something harder makes it truer. Zibrah Code refuses that collapse. Truth stands on its own line. Perception stands on its own line. What happens between them &mdash; the angle &mdash; is where belief actually lives.</p>\n<p>This separation is the entire foundation. Once truth and perception are treated as independent, their relationship becomes something that can be measured, not just argued about. A narrow angle signals rigid belief. A wide angle signals openness. Neither position is inherently right &mdash; but each is visible, and visibility is the beginning of correction.</p>\n<p>The diagram that accompanies this structure is not decoration. It is the argument. Two dimensions, held apart, describe more about human disagreement than a thousand words of explanation could.</p>\n<p>Every axiom that follows in the Zibrah Code framework &mdash; how belief forms, how extremes mirror each other, how wisdom differs from projection &mdash; descends directly from this one structural decision: keep truth and perception separate, and watch what moves between them.</p>\n<p>Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.</p>\n<p class=\"font-bold text-brand-gold italic\">Angles show what words cannot tell.</p>",
        'featured_image_path' => 'assets/images/blog.png',
        'category' => 'Framework & Theory',
        'published_at' => '2026-05-13 09:00:00',
        'meta_description' => 'Explore the foundational geometric structure of the Zibrah Code model — a visual representation of how truth and perception interact to form belief, conflict, and wisdom.',
        'legacy_slug' => 'post-structure.php',
    ]);

    $stmt->execute([
        'title' => 'Angles Show What Words Cannot Tell',
        'slug' => 'angles-show-what-words-cannot-tell',
        'excerpt' => 'Most conflicts do not begin with malice. They begin with certainty.',
        'body' => "<p>Most conflicts do not begin with malice. They begin with certainty.</p>\n<p>Certainty feels like clarity, but the two are not the same. Clarity remains responsive. Certainty accelerates.</p>\n<p>When belief accelerates faster than understanding, something subtle but decisive happens: listening weakens, correction fails, and disagreement begins to feel like threat.</p>\n<p>This is not a failure of intelligence. It is not a moral defect. It is structural.</p>\n<p>Belief moves. It moves through affirmation and doubt, through confidence and restraint, through openness and closure. These movements follow patterns that are surprisingly consistent across individuals, groups, institutions, and societies.</p>\n<p>Arguments try to interrupt these patterns. They rarely succeed. Geometry, however, reveals them.</p>\n<p>When belief remains open, its angles are wide. When belief hardens, angles narrow. When belief closes, angles lock. None of this requires judgment. It can be seen.</p>\n<p>This is why some conversations fail no matter how well they are argued. It is why mediation arrives too late. It is why leadership escalates problems it intends to solve. And it is why radicalization does not feel radical from the inside.</p>\n<p>Belief does not collapse suddenly. It closes gradually.</p>\n<p>There is usually a moment&mdash;quiet and easy to miss&mdash;when reality is still acknowledged but no longer obeyed. From that point onward, correction becomes ineffective, not because facts disappear, but because belief can no longer rotate.</p>\n<p>Understanding this changes nothing immediately. And yet, it changes everything eventually. Because once belief is seen as something that moves, narrows, and locks, blame loses its usefulness. The question shifts from <em>who is wrong</em> to <em>what stage has been reached</em>. That shift alone lowers temperature.</p>\n<p>The most important insight, however, comes later. As people learn to recognize these patterns outwardly&mdash;in conflicts, in leaders, in movements&mdash;they eventually encounter the same geometry inwardly. This recognition is rarely announced. It does not need to be. It is private, personal, and often silent.</p>\n<p>That silence is not avoidance. It is understanding settling.</p>\n<p>The most durable insights do not arrive through force. They arrive when structure becomes visible.</p>\n<p class=\"font-bold text-brand-gold italic\">Angles show what words cannot tell.</p>",
        'featured_image_path' => 'assets/images/wisdom.jpg',
        'category' => 'Strategic Research',
        'published_at' => '2026-02-20 09:00:00',
        'meta_description' => 'Most conflicts begin with certainty, not malice. Explore how belief narrows and locks — and why geometry reveals what arguments cannot.',
        'legacy_slug' => 'post-angles.php',
    ]);
};
