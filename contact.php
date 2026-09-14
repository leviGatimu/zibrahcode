<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Contact Ibrahim Ngugi | Zibrah Code™';
$pageDescription = 'Get in touch with Ibrahim Ngugi and the Zibrah Code team for institutional correspondence, speaking, or press inquiries.';
$canonicalPath = '/contact.php';
$activeNav = 'contact';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Contact","item":"' . SITE_URL . '/contact.php"}]}',
];
require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-40 pb-32 max-w-3xl mx-auto">
    <div class="text-center mb-20 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Get in Touch</h4>
        <h1 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black">Contact.</h1>
    </div>

    <form action="/actions/contact-submit" method="POST" class="space-y-10 reveal active">
        <?php echo csrfField(); ?>
        <div class="grid md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label for="contact-name" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Full Name</label>
                <input type="text" name="name" id="contact-name" required class="form-input">
            </div>
            <div class="space-y-4">
                <label for="contact-email" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Email Address</label>
                <input type="email" name="email" id="contact-email" required class="form-input">
            </div>
        </div>
        <div class="space-y-4">
            <label for="contact-subject" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Subject</label>
            <input type="text" name="subject" id="contact-subject" class="form-input">
        </div>
        <div class="space-y-4">
            <label for="contact-message" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Message</label>
            <textarea name="message" id="contact-message" required rows="6" class="form-textarea"></textarea>
        </div>
        <button type="submit" class="btn-premium w-full py-8 text-sm tracking-[0.4em]">Send Message</button>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
