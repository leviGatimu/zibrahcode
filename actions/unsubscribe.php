<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$email = trim($_GET['email'] ?? $_POST['email'] ?? '');
$token = trim($_GET['token'] ?? $_POST['token'] ?? '');
$valid = $email !== '' && $token !== '' && unsubscribeTokenValid($email, $token);

if ($valid) {
    getDb()->prepare('UPDATE newsletter_subscribers SET status = "unsubscribed", unsubscribed_at = NOW() WHERE email = ?')->execute([$email]);
}

// RFC 8058 one-click unsubscribe: mail clients (Gmail, etc.) POST here directly
// when the user clicks "Unsubscribe" in their own UI — just acknowledge, no page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    http_response_code($valid ? 200 : 400);
    exit;
}

$pageTitle = 'Unsubscribed | Zibrah Code™';
$canonicalPath = '/actions/unsubscribe.php';
$activeNav = '';
$robotsMeta = 'noindex, nofollow';
require __DIR__ . '/../includes/header.php';
?>
<main class="section-container pt-48 pb-16 md:pb-32 text-center min-h-[50vh] flex flex-col items-center justify-center">
    <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10"><?php echo $valid ? 'Unsubscribed' : 'Link Invalid'; ?></p>
    <?php if ($valid): ?>
        <h1 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tighter mb-10">You've been unsubscribed.</h1>
        <p class="text-xl text-brand-gray-600 font-light max-w-xl mb-12"><?php echo e($email); ?> will no longer receive Zibrah Code email updates. Changed your mind? You can resubscribe any time from the homepage.</p>
    <?php else: ?>
        <h1 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tighter mb-10">That link isn't valid.</h1>
        <p class="text-xl text-brand-gray-600 font-light max-w-xl mb-12">This unsubscribe link may be incomplete or expired.</p>
    <?php endif; ?>
    <a href="/index.php" class="btn-premium">Back to Home</a>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
