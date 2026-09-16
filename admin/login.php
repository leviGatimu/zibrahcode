<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$adminCount = (int) getDb()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($adminCount === 0) {
    redirectTo('/admin/setup.php');
}

if (currentAdmin()) {
    redirectTo('/admin/index.php');
}

$error = '';
$loginIdentifier = 'admin:' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isLoginLocked($loginIdentifier)) {
        $error = 'Too many failed attempts. Please wait a few minutes and try again.';
    } elseif (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = getDb()->prepare('SELECT id, password_hash FROM admin_users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $username]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            clearLoginFailures($loginIdentifier);
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            getDb()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = ?')->execute([$admin['id']]);
            redirectTo('/admin/index.php');
        } else {
            recordLoginFailure($loginIdentifier);
            $error = 'Incorrect username or password.';
        }
    }
}
$pageTitle = 'Admin Login | Zibrah Code';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,400..700;1,8..60,400..700&family=Inter:wght@200..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { brand: { black: '#1A1A1A', gold: '#B89441', 'gold-light': '#D4B876' } }, fontFamily: { display: ['var(--font-serif)'], serif: ['var(--font-serif)'], sans: ['var(--font-sans)'] } } }
        }
    </script>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo ASSETS_VERSION; ?>">
    <meta name="csrf-token" content="<?php echo e(csrfToken()); ?>">
</head>
<body class="bg-brand-black min-h-screen flex items-center justify-center font-sans relative overflow-hidden px-6">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] border border-white/5 rounded-full pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] border border-white/5 rounded-full pointer-events-none"></div>

    <div class="relative z-10 max-w-md w-full">
        <div class="text-center mb-10">
            <div class="font-display font-black text-2xl tracking-[0.3em] uppercase text-white">Zibrah Code<span class="text-brand-gold">™</span></div>
            <div class="text-[10px] text-brand-gold uppercase tracking-[0.5em] mt-2">Admin</div>
        </div>

        <div class="bg-white p-10 sm:p-12 shadow-2xl">
            <h1 class="font-serif text-3xl font-bold text-brand-black mb-2">Sign In.</h1>
            <p class="text-sm text-brand-gray-500 mb-8">Zibrah Code content management.</p>
            <?php if ($error): ?><p class="mb-6 p-4 bg-red-50 border border-red-300 text-red-700 text-sm"><?php echo e($error); ?></p><?php endif; ?>
            <form method="POST" class="space-y-6">
                <?php echo csrfField(); ?>
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-[0.3em] font-bold text-brand-black">Username or Email</label>
                    <input type="text" name="username" required class="form-input">
                </div>
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-[0.3em] font-bold text-brand-black">Password</label>
                    <input type="password" name="password" required class="form-input">
                </div>
                <button type="submit" class="btn-gold w-full py-4 text-xs tracking-[0.3em]">Sign In</button>
            </form>
        </div>

        <p class="text-center mt-8">
            <a href="/index.php" class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/30 hover:text-brand-gold transition-colors">&larr; Back to Site</a>
        </p>
    </div>
</body>
</html>
