<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

$pageTitle = 'Preferences | Zibrah Code™';
$pageDescription = 'Manage your Zibrah Code newsletter preferences.';
$canonicalPath = '/account/preferences.php';
$activeNav = '';
$robotsMeta = 'noindex, nofollow';
require __DIR__ . '/../includes/header.php';

$user = currentUser();
$subStmt = getDb()->prepare('SELECT status FROM newsletter_subscribers WHERE email = ?');
$subStmt->execute([$user['email']]);
$subscription = $subStmt->fetch();
$isSubscribed = $subscription ? $subscription['status'] === 'subscribed' : (bool) $user['newsletter_opt_in'];
?>

<main class="section-container pt-32 pb-20 max-w-5xl mx-auto">
    <div class="mb-16 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-3">My Account</h4>
        <h1 class="text-4xl md:text-5xl serif text-brand-black leading-none tracking-tighter font-black">Preferences.</h1>
    </div>

    <nav class="flex gap-8 border-b border-brand-gray-200 mb-16">
        <a href="/account/index.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Profile</a>
        <a href="/account/bookmarks.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Bookmarks</a>
        <span class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gold border-b-2 border-brand-gold">Preferences</span>
    </nav>

    <form action="/actions/preferences-update" method="POST" class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 max-w-2xl reveal active">
        <?php echo csrfField(); ?>
        <div class="flex items-center gap-3 mb-8">
            <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            <h3 class="text-xs font-black uppercase tracking-[0.3em] text-brand-black">Email Preferences</h3>
        </div>
        <div class="flex items-center justify-between p-6 bg-white border border-brand-gray-200">
            <div>
                <h4 class="font-bold text-brand-black mb-1">Newsletter</h4>
                <p class="text-sm text-brand-gray-500">Receive new articles and podcast episodes by email.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-6">
                <input type="checkbox" name="newsletter_opt_in" value="1" <?php echo $isSubscribed ? 'checked' : ''; ?> class="sr-only peer">
                <div class="w-14 h-8 bg-brand-gray-300 peer-checked:bg-brand-gold transition-all relative">
                    <div class="absolute top-1 left-1 w-6 h-6 bg-white transition-all peer-checked:translate-x-6"></div>
                </div>
            </label>
        </div>
        <button type="submit" class="btn-premium w-full mt-6">Save Preferences</button>
    </form>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
