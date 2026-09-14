<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (currentUser()) {
    redirectTo('/account/index.php');
}

$pageTitle = 'Sign In | Zibrah Code™';
$pageDescription = 'Sign in to your Zibrah Code account.';
$canonicalPath = '/login.php';
$activeNav = '';
$robotsMeta = 'noindex, follow';
$redirectTarget = safeRedirectPath($_GET['redirect'] ?? null, '/account/index.php');
require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-28 md:pt-40 pb-16 md:pb-32 max-w-md mx-auto">
    <div class="text-center mb-10 md:mb-16 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Welcome Back</h4>
        <h1 class="text-5xl md:text-6xl serif text-brand-black leading-none tracking-tighter font-black">Sign In.</h1>
    </div>

    <form action="/actions/login-submit" method="POST" class="space-y-8 reveal active">
        <?php echo csrfField(); ?>
        <input type="hidden" name="redirect" value="<?php echo e($redirectTarget); ?>">
        <div class="space-y-3">
            <label for="login-email" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Email</label>
            <input type="email" name="email" id="login-email" required class="form-input">
        </div>
        <div class="space-y-3">
            <label for="login-password" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Password</label>
            <input type="password" name="password" id="login-password" required class="form-input">
        </div>
        <button type="submit" class="btn-premium w-full py-6 text-sm tracking-[0.4em]">Sign In</button>
    </form>

    <p class="text-center text-brand-gray-600 mt-10">
        Don't have an account? <a href="/register.php" class="text-brand-gold font-bold hover:underline">Create one</a>
    </p>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
