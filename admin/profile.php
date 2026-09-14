<?php
require_once __DIR__ . '/includes/admin-auth-check.php';

$admin = currentAdmin();
$db = getDb();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrfVerify()) {
    $error = 'Invalid form submission, please try again.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $displayName = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please provide a valid email address.';
    } else {
        $avatarPath = $admin['avatar_path'] ?? null;
        if (!empty($_FILES['avatar']['name'])) {
            $uploadedAvatar = handleImageUpload($_FILES['avatar'], 'admin/avatars', $admin['username']);
            if ($uploadedAvatar) {
                $avatarPath = $uploadedAvatar;
            } else {
                $error = 'Profile picture upload failed — please use a JPG, PNG, or WEBP under 5MB.';
            }
        }

        if (!$error) {
            $db->prepare('UPDATE admin_users SET display_name = ?, email = ?, avatar_path = ? WHERE id = ?')->execute([$displayName ?: null, $email, $avatarPath, $admin['id']]);
            flashSet('success', 'Profile updated.');
            redirectTo('/admin/profile.php');
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $stmt = $db->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([$admin['id']]);
    $row = $stmt->fetch();
    if (!password_verify($current, $row['password_hash'])) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($new) < 8) {
        $error = 'New password must be at least 8 characters.';
    } else {
        $db->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), $admin['id']]);
        flashSet('success', 'Password updated.');
        redirectTo('/admin/profile.php');
    }
}

$pageTitle = 'Profile | Zibrah Code Admin';
$activeAdminNav = 'profile';
require __DIR__ . '/includes/admin-header.php';

$initial = mb_strtoupper(mb_substr($admin['display_name'] ?: $admin['username'], 0, 1));
?>

<!-- PROFILE HEADER -->
<div class="flex items-center gap-5 mb-12">
    <?php if (!empty($admin['avatar_path'])): ?>
        <img id="profile-avatar-preview" src="/<?php echo e($admin['avatar_path']); ?>" alt="<?php echo e($admin['display_name'] ?: $admin['username']); ?>" class="w-16 h-16 rounded-full object-cover flex-shrink-0">
    <?php else: ?>
        <div id="profile-avatar-preview-initial" class="w-16 h-16 rounded-full bg-brand-black text-brand-gold font-display font-black text-2xl flex items-center justify-center flex-shrink-0"><?php echo e($initial); ?></div>
        <img id="profile-avatar-preview" alt="<?php echo e($admin['display_name'] ?: $admin['username']); ?>" class="w-16 h-16 rounded-full object-cover flex-shrink-0 hidden">
    <?php endif; ?>
    <div class="min-w-0">
        <h1 class="font-display font-black text-2xl sm:text-3xl text-brand-black truncate"><?php echo e($admin['display_name'] ?: $admin['username']); ?></h1>
        <p class="text-sm text-gray-500 truncate"><?php echo e($admin['email']); ?></p>
    </div>
</div>

<?php if ($error): ?><p class="mb-8 p-4 bg-red-50 border border-red-300 text-red-700 text-sm max-w-2xl"><?php echo e($error); ?></p><?php endif; ?>

<div class="grid lg:grid-cols-2 gap-6 max-w-4xl">
    <form method="POST" enctype="multipart/form-data" class="bg-white border border-gray-100 p-6 sm:p-8">
        <?php echo csrfField(); ?>
        <input type="hidden" name="action" value="update_profile">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <h2 class="font-bold text-brand-black uppercase text-xs tracking-widest">Account Details</h2>
        </div>
        <div class="space-y-5">
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Profile Picture</label>
                <input type="file" name="avatar" id="avatar-input" accept="image/jpeg,image/png,image/webp" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 text-sm">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Display Name</label>
                <input type="text" name="display_name" value="<?php echo e($admin['display_name'] ?? ''); ?>" class="form-input mt-2">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Email</label>
                <input type="email" name="email" value="<?php echo e($admin['email']); ?>" required class="form-input mt-2">
            </div>
            <button type="submit" class="w-full bg-brand-black text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Save Changes</button>
        </div>
    </form>

    <form method="POST" class="bg-white border border-gray-100 p-6 sm:p-8">
        <?php echo csrfField(); ?>
        <input type="hidden" name="action" value="update_password">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <h2 class="font-bold text-brand-black uppercase text-xs tracking-widest">Change Password</h2>
        </div>
        <div class="space-y-5">
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Current Password</label>
                <input type="password" name="current_password" required class="form-input mt-2">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">New Password</label>
                <input type="password" name="new_password" required minlength="8" class="form-input mt-2">
            </div>
            <button type="submit" class="w-full bg-brand-black text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Update Password</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('avatar-input').addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const objectUrl = URL.createObjectURL(this.files[0]);
        const preview = document.getElementById('profile-avatar-preview');
        const initial = document.getElementById('profile-avatar-preview-initial');
        preview.src = objectUrl;
        preview.classList.remove('hidden');
        if (initial) { initial.classList.add('hidden'); }
    });
</script>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
