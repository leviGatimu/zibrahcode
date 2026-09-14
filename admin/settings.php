<?php
require_once __DIR__ . '/includes/admin-auth-check.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } elseif (($_POST['settings_section'] ?? '') === 'blog') {
        setSetting('show_view_counts', isset($_POST['show_view_counts']) ? '1' : '0');
        flashSet('success', 'Settings saved.');
        redirectTo('/admin/settings.php');
    } else {
        $newKey = trim($_POST['google_api_key'] ?? '');
        if ($newKey !== '') {
            setSetting('google_api_key', $newKey);
        }
        flashSet('success', 'Settings saved.');
        redirectTo('/admin/settings.php');
    }
}

$hasGoogleApiKey = getSetting('google_api_key') !== null;
$showViewCounts = getSetting('show_view_counts') === '1';

$pageTitle = 'Settings | Zibrah Code Admin';
$activeAdminNav = 'settings';
require __DIR__ . '/includes/admin-header.php';
?>

<h1 class="font-display font-black text-3xl text-brand-black mb-10">Settings</h1>

<?php if ($error): ?><p class="mb-8 p-4 bg-red-50 border border-red-300 text-red-700 text-sm max-w-2xl"><?php echo e($error); ?></p><?php endif; ?>

<form method="POST" class="bg-white border border-gray-100 p-6 sm:p-8 max-w-2xl">
    <?php echo csrfField(); ?>
    <div class="flex items-center gap-3 mb-6">
        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.127.332-.184.582-.496.644-.87l.214-1.28z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <h2 class="font-bold text-brand-black uppercase text-xs tracking-widest">AI Integration</h2>
    </div>
    <div class="space-y-5">
        <div>
            <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Google API Key (Gemini)</label>
            <input type="password" name="google_api_key" placeholder="<?php echo $hasGoogleApiKey ? '•••• saved — enter a new key to replace it' : 'Paste your Gemini API key'; ?>"
                class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            <p class="text-xs text-gray-400 mt-2">Powers the "Generate with AI" meta description button on the blog post editor. Get a key from <a href="https://aistudio.google.com/apikey" target="_blank" rel="noopener" class="text-brand-gold hover:underline">Google AI Studio</a>.</p>
        </div>
        <button type="submit" class="bg-brand-black text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Save Settings</button>
    </div>
</form>

<form method="POST" class="bg-white border border-gray-100 p-6 sm:p-8 max-w-2xl mt-8">
    <?php echo csrfField(); ?>
    <input type="hidden" name="settings_section" value="blog">
    <div class="flex items-center gap-3 mb-6">
        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <h2 class="font-bold text-brand-black uppercase text-xs tracking-widest">Blog Settings</h2>
    </div>
    <div class="flex items-center justify-between p-6 bg-gray-50 border border-gray-200">
        <div>
            <h4 class="font-bold text-brand-black mb-1">Show view counts publicly</h4>
            <p class="text-sm text-gray-500">When on, readers see each post's view count on the blog and post pages. You can always see view counts yourself on the Blog Posts list, regardless of this setting.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-6">
            <input type="checkbox" name="show_view_counts" value="1" <?php echo $showViewCounts ? 'checked' : ''; ?> class="sr-only peer">
            <div class="w-14 h-8 bg-gray-300 peer-checked:bg-brand-gold transition-all relative">
                <div class="absolute top-1 left-1 w-6 h-6 bg-white transition-all peer-checked:translate-x-6"></div>
            </div>
        </label>
    </div>
    <button type="submit" class="bg-brand-black text-white px-8 py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all mt-6">Save Settings</button>
</form>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
