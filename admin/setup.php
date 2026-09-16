<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$existingCount = (int) getDb()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($existingCount > 0) {
    redirectTo('/admin/login.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $displayName = trim($_POST['display_name'] ?? '');

        if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            $error = 'Please provide a username, a valid email, and a password of at least 8 characters.';
        } else {
            $stmt = getDb()->prepare('INSERT INTO admin_users (username, email, password_hash, display_name) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $displayName ?: null]);
            redirectTo('/admin/login.php');
        }
    }
}

$pageTitle = 'Admin Setup | Zibrah Code';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($pageTitle); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400..700;1,8..60,400..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { brand: { black: '#1A1A1A', gold: '#B89441' } }, fontFamily: { display: ['var(--font-sans)'], sans: ['var(--font-sans)'] } } } }</script>
</head>
<body class="bg-brand-black min-h-screen flex items-center justify-center font-sans">
    <div class="max-w-md w-full bg-white p-12 shadow-2xl">
        <h1 class="font-display font-black text-2xl uppercase tracking-widest text-brand-black mb-2">Admin Setup</h1>
        <p class="text-sm text-gray-500 mb-8">Create the single admin account for the Zibrah Code site. This form only appears once.</p>
        <?php if ($error): ?><p class="mb-6 p-4 bg-red-50 border border-red-300 text-red-700 text-sm"><?php echo e($error); ?></p><?php endif; ?>
        <form method="POST" class="space-y-5">
            <?php echo csrfField(); ?>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Username</label>
                <input type="text" name="username" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Display Name</label>
                <input type="text" name="display_name" placeholder="Ibrahim Ngugi" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Password</label>
                <input type="password" name="password" required minlength="8" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <button type="submit" class="w-full bg-brand-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Create Admin Account</button>
        </form>
    </div>
</body>
</html>
