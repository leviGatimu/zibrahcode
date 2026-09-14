<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (currentUser()) {
    redirectTo('/account/index.php');
}

$pageTitle = 'Create an Account | Zibrah Code™';
$pageDescription = 'Create a free Zibrah Code account to bookmark articles, join the conversation, and manage your newsletter preferences.';
$canonicalPath = '/register.php';
$activeNav = '';
$robotsMeta = 'noindex, follow';
$redirectTarget = safeRedirectPath($_GET['redirect'] ?? null, '/account/index.php');
require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-32 pb-20 max-w-md mx-auto">
    <div class="text-center mb-16 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Join Us</h4>
        <h1 class="text-5xl md:text-6xl serif text-brand-black leading-none tracking-tighter font-black">Create Account.</h1>
    </div>

    <form action="/actions/register-submit" method="POST" class="space-y-8 reveal active">
        <?php echo csrfField(); ?>
        <input type="hidden" name="redirect" value="<?php echo e($redirectTarget); ?>">
        <div class="space-y-3">
            <label for="register-name" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Full Name</label>
            <input type="text" name="name" id="register-name" required class="form-input">
        </div>
        <div class="space-y-3">
            <label for="register-email" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Email</label>
            <input type="email" name="email" id="register-email" required class="form-input">
        </div>
        <div class="space-y-3">
            <label for="register-password" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Password</label>
            <input type="password" name="password" id="register-password" required minlength="8" class="form-input">
        </div>
        <label class="flex items-center gap-3 text-sm text-brand-gray-600">
            <input type="checkbox" name="newsletter_opt_in" value="1" checked class="accent-brand-gold w-4 h-4">
            Keep me updated on new articles and episodes
        </label>
        <button type="submit" class="btn-premium w-full py-6 text-sm tracking-[0.4em]">Create Account</button>
    </form>

    <p class="text-center text-brand-gray-600 mt-10">
        Already have an account? <a href="/login.php" class="text-brand-gold font-bold hover:underline">Sign in</a>
    </p>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
