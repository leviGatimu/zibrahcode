<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Book a Consultation with Ibrahim Ngugi | Zibrah Code™';
$pageDescription = 'Book a time to speak with Ibrahim Ngugi for speaking engagements, consulting, media, or a personal conversation about the Zibrah Code.';
$canonicalPath = '/inquire.php';
$activeNav = 'inquire';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Inquire","item":"' . SITE_URL . '/inquire.php"}]}',
];
require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-28 md:pt-40 pb-16 md:pb-32 max-w-3xl mx-auto">
    <div class="text-center mb-12 md:mb-20 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Book a Time</h4>
        <h1 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black">Inquire.</h1>
        <p class="text-lg text-brand-gray-600 font-light leading-relaxed mt-10 max-w-xl mx-auto">
            Request a time to speak with Ibrahim directly for speaking engagements, consulting, media, or a personal conversation about the Zibrah Code.
        </p>
    </div>

    <form action="/actions/inquire-submit" method="POST" class="space-y-10 reveal active">
        <?php echo csrfField(); ?>
        <?php echo spamGuardFields(); ?>
        <div class="grid md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label for="inquire-name" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Full Name</label>
                <input type="text" name="name" id="inquire-name" required class="form-input">
            </div>
            <div class="space-y-4">
                <label for="inquire-email" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Email Address</label>
                <input type="email" name="email" id="inquire-email" required class="form-input">
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label for="inquire-phone" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Phone <span class="text-brand-gray-400 font-normal normal-case tracking-normal">(optional)</span></label>
                <input type="tel" name="phone" id="inquire-phone" class="form-input">
            </div>
            <div class="space-y-4">
                <label for="inquire-topic" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Reason for Inquiry</label>
                <select name="topic" id="inquire-topic" class="form-input">
                    <option value="Speaking">Speaking Engagement</option>
                    <option value="Consulting">Consulting</option>
                    <option value="Media">Media / Press</option>
                    <option value="Personal">Personal Conversation</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-10">
            <div class="space-y-4">
                <label for="inquire-date" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Preferred Date <span class="text-brand-gray-400 font-normal normal-case tracking-normal">(optional)</span></label>
                <input type="date" name="preferred_date" id="inquire-date" class="form-input">
            </div>
            <div class="space-y-4">
                <label for="inquire-time" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Preferred Time <span class="text-brand-gray-400 font-normal normal-case tracking-normal">(optional)</span></label>
                <select name="preferred_time" id="inquire-time" class="form-input">
                    <option value="">No preference</option>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
        </div>
        <div class="space-y-4">
            <label for="inquire-message" class="text-xs uppercase tracking-[0.4em] text-brand-black font-black">Message</label>
            <textarea name="message" id="inquire-message" rows="6" placeholder="Tell us a bit about what you'd like to discuss..." class="form-textarea"></textarea>
        </div>
        <button type="submit" class="btn-premium w-full py-8 text-sm tracking-[0.4em]">Request a Time</button>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
