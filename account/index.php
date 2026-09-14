<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

$pageTitle = 'My Account | Zibrah Code™';
$pageDescription = 'Manage your Zibrah Code account.';
$canonicalPath = '/account/index.php';
$activeNav = '';
$robotsMeta = 'noindex, nofollow';
require __DIR__ . '/../includes/header.php';

$user = currentUser();
?>

<main class="section-container pt-40 pb-32 max-w-5xl mx-auto">
    <div class="flex items-center gap-6 mb-16 reveal active">
        <?php if (!empty($user['avatar_path'])): ?>
            <img id="profile-avatar-preview" src="/<?php echo e($user['avatar_path']); ?>" alt="<?php echo e($user['name']); ?>" class="w-20 h-20 rounded-full object-cover flex-shrink-0">
        <?php else: ?>
            <div id="profile-avatar-preview-initial" class="w-20 h-20 rounded-full bg-brand-black text-brand-gold font-display font-black text-3xl flex items-center justify-center flex-shrink-0">
                <?php echo e(mb_strtoupper(mb_substr($user['name'], 0, 1))); ?>
            </div>
            <img id="profile-avatar-preview" alt="<?php echo e($user['name']); ?>" class="w-20 h-20 rounded-full object-cover flex-shrink-0 hidden">
        <?php endif; ?>
        <div class="min-w-0">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-3">My Account</h4>
            <h1 class="text-4xl md:text-5xl serif text-brand-black leading-none tracking-tighter font-black truncate">Hello, <?php echo e($user['name']); ?>.</h1>
        </div>
    </div>

    <nav class="flex gap-8 border-b border-brand-gray-200 mb-16">
        <span class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gold border-b-2 border-brand-gold">Profile</span>
        <a href="/account/bookmarks.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Bookmarks</a>
        <a href="/account/preferences.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Preferences</a>
    </nav>

    <div class="grid lg:grid-cols-2 gap-8">
        <form action="/actions/account-update" method="POST" enctype="multipart/form-data" class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 reveal active">
            <?php echo csrfField(); ?>
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-brand-black">Profile Details</h3>
            </div>
            <div class="space-y-6">
                <div class="space-y-3">
                    <label for="account-avatar" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Profile Picture</label>
                    <input type="file" name="avatar" id="account-avatar" accept="image/jpeg,image/png,image/webp" class="form-input">
                </div>
                <div class="space-y-3">
                    <label for="account-name" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Full Name</label>
                    <input type="text" name="name" id="account-name" value="<?php echo e($user['name']); ?>" required class="form-input">
                </div>
                <div class="space-y-3">
                    <label for="account-email" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Email</label>
                    <input type="email" id="account-email" value="<?php echo e($user['email']); ?>" disabled class="form-input">
                </div>
                <button type="submit" class="btn-premium w-full">Save Changes</button>
            </div>
        </form>

        <form action="/actions/account-password" method="POST" class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 reveal active">
            <?php echo csrfField(); ?>
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-brand-black">Change Password</h3>
            </div>
            <div class="space-y-6">
                <div class="space-y-3">
                    <label for="account-current-password" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Current Password</label>
                    <input type="password" name="current_password" id="account-current-password" required class="form-input">
                </div>
                <div class="space-y-3">
                    <label for="account-new-password" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">New Password</label>
                    <input type="password" name="new_password" id="account-new-password" required minlength="8" class="form-input">
                </div>
                <button type="submit" class="btn-premium w-full">Update Password</button>
            </div>
        </form>
    </div>
</main>

<script>
    document.getElementById('account-avatar').addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const objectUrl = URL.createObjectURL(this.files[0]);
        const preview = document.getElementById('profile-avatar-preview');
        const initial = document.getElementById('profile-avatar-preview-initial');
        preview.src = objectUrl;
        preview.classList.remove('hidden');
        if (initial) { initial.classList.add('hidden'); }
    });
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
