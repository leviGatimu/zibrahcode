<?php
require_once __DIR__ . '/includes/bootstrap.php';

header('Content-Type: application/xml; charset=UTF-8');

$db = getDb();
$posts = $db->query("SELECT slug, updated_at FROM posts WHERE status = 'published' ORDER BY published_at DESC")->fetchAll();
$episodes = $db->query("SELECT slug, updated_at FROM podcast_episodes WHERE status = 'published' ORDER BY published_at DESC")->fetchAll();

$staticPages = [
    ['loc' => '/', 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => '/about.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/book.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/framework.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/blog.php', 'changefreq' => 'daily', 'priority' => '0.9'],
    ['loc' => '/podcast.php', 'changefreq' => 'weekly', 'priority' => '0.8'],
    ['loc' => '/inquire.php', 'changefreq' => 'monthly', 'priority' => '0.6'],
    ['loc' => '/contact.php', 'changefreq' => 'monthly', 'priority' => '0.5'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
    <url>
        <loc><?php echo e(rtrim(SITE_URL, '/') . $page['loc']); ?></loc>
        <changefreq><?php echo $page['changefreq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
<?php endforeach; ?>
<?php foreach ($posts as $post): ?>
    <url>
        <loc><?php echo e(rtrim(SITE_URL, '/') . '/post.php?slug=' . $post['slug']); ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($post['updated_at'] ?: 'now')); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
<?php endforeach; ?>
<?php foreach ($episodes as $episode): ?>
    <url>
        <loc><?php echo e(rtrim(SITE_URL, '/') . '/podcast-episode.php?slug=' . $episode['slug']); ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($episode['updated_at'] ?: 'now')); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
<?php endforeach; ?>
</urlset>
