<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'The Book | Zibrah Code™ — The Geometry of Truth and Wisdom';
$pageDescription = 'Zibrah Code: The Geometry of Truth and Wisdom by Ibrahim Ngugi — a geometric model separating truth and perception to reveal how belief and conflict evolve.';
$canonicalPath = '/book.php';
$activeNav = 'book';
$ogImage = SITE_URL . '/assets/images/Front page.png';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"Book","name":"Zibrah Code: The Geometry of Truth and Wisdom","alternateName":"ZibrahCode","author":{"@type":"Person","name":"Ibrahim Ngugi"},"url":"' . SITE_URL . '/book.php","image":"' . SITE_URL . '/assets/images/Front page.png","description":' . json_encode($pageDescription) . ',"inLanguage":"en","genre":["Leadership","Philosophy","Strategic Thinking","Conflict Resolution"],"offers":{"@type":"Offer","availability":"https://schema.org/InStock","url":"' . AMAZON_URL . '","seller":{"@type":"Organization","name":"Amazon"}}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"The Book","item":"' . SITE_URL . '/book.php"}]}',
];
require __DIR__ . '/includes/header.php';
?>

<!-- FULL-BLEED COVER HERO — mobile only -->
<header class="lg:hidden relative h-[65vh] min-h-[440px] w-full overflow-hidden mt-0">
    <img src="/assets/images/Front page.png" alt="Zibrah Code Book Cover"
        class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/60 to-transparent"></div>
    <div class="absolute inset-0 bg-brand-black/20"></div>
    <div class="absolute bottom-0 left-0 right-0 section-container pb-14 reveal active">
        <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">About the Book</p>
        <h1 class="text-5xl sm:text-6xl font-display font-black text-white uppercase tracking-tighter leading-[0.9]">The Zibrah<br>Code.</h1>
    </div>
</header>

<!-- BOXED COVER HEADER — desktop only, sits below the nav, no overlap -->
<div class="hidden lg:block section-container pt-40 pb-16">
    <div class="grid lg:grid-cols-5 gap-16 items-center">
        <div class="lg:col-span-3 reveal active">
            <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">About the Book</p>
            <h1 class="text-7xl xl:text-8xl font-display font-black text-brand-black uppercase tracking-tighter leading-[0.9]">The Zibrah<br>Code.</h1>
        </div>
        <div class="lg:col-span-2 reveal active relative flex justify-center">
            <div class="absolute transform -translate-x-8 translate-y-6 -rotate-12 opacity-30">
                <img src="/assets/images/Back page.png" alt="Zibrah Code Back Cover" class="w-40 h-auto shadow-2xl">
            </div>
            <div class="relative z-10 max-w-[260px] transform -rotate-2 shadow-[0_60px_120px_-20px_rgba(0,0,0,0.6)]">
                <img src="/assets/images/Front page.png" alt="Zibrah Code Book Cover" class="w-full h-auto" fetchpriority="high">
            </div>
        </div>
    </div>
</div>

<!-- QUOTE + INTRO ASYMMETRIC ROW -->
<section class="py-24 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-2 reveal active">
                <p class="text-3xl md:text-4xl serif italic text-brand-black leading-snug border-l-4 border-brand-gold pl-8">
                    Angles show what words cannot tell.
                </p>
            </div>
            <div class="lg:col-span-3 reveal active">
                <p class="drop-cap text-xl sm:text-2xl md:text-2xl text-brand-gray-700 font-light leading-relaxed mb-8">
                    The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                    interact under pressure. By mapping movement between truth and perception, the model reveals
                    why leadership decisions harden, why conflict escalates, and how stability can be restored
                    before breakdown occurs.
                </p>
                <p class="text-xl md:text-2xl text-brand-gray-700 font-light leading-relaxed mb-10">
                    Rather than treating truth and perception as a single sliding scale, the Zibrah Code holds them
                    apart as independent dimensions. What happens between them — the angle — is where belief
                    actually lives, and it is that angle, not the argument, that determines whether a conflict
                    opens or closes.
                </p>
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
            </div>
        </div>
    </div>
</section>

<!-- STAT STRIP -->
<section class="py-20 bg-brand-black text-white">
    <div class="section-container grid grid-cols-1 sm:grid-cols-3 gap-12 text-center">
        <div class="reveal active">
            <p class="text-5xl md:text-6xl font-display font-black text-brand-gold mb-3">5</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Core Axioms</p>
        </div>
        <div class="reveal active">
            <p class="text-2xl md:text-3xl font-display font-black text-brand-gold mb-3">Kindle + Print</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Available Formats</p>
        </div>
        <div class="reveal active">
            <p class="text-lg md:text-xl font-display font-black text-brand-gold mb-3">Leadership &middot; Philosophy &middot; Conflict</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Fields It Speaks To</p>
        </div>
    </div>
</section>

<!-- WHY THIS BOOK MATTERS -->
<section class="py-24 md:py-32 bg-white">
    <div class="section-container text-center mb-24 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Strategic Impact</h4>
        <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black leading-tight tracking-tighter font-black">Why This Book Matters.</h2>
    </div>
    <div class="section-container grid md:grid-cols-3 gap-12">
        <div class="card bg-brand-gray-50 p-8 md:p-16 reveal active">
            <div class="w-16 h-16 bg-brand-black flex items-center justify-center text-white mb-10 serif text-3xl font-bold">A</div>
            <h4 class="text-3xl serif mb-8 text-brand-black font-bold">A new lens</h4>
            <p class="text-xl text-brand-gray-600 font-light leading-relaxed">An inclusive, proactive, structural way of understanding belief and preventing conflict — one that does not require picking a side before the geometry is even visible.</p>
        </div>
        <div class="card bg-brand-gray-50 p-8 md:p-16 reveal active">
            <div class="w-16 h-16 bg-brand-black flex items-center justify-center text-white mb-10 serif text-3xl font-bold">W</div>
            <h4 class="text-3xl serif mb-8 text-brand-black font-bold">Wisdom Engineering</h4>
            <p class="text-xl text-brand-gray-600 font-light leading-relaxed">Wisdom in leadership preserves angular movement and avoids closure in conflict mediation, keeping options open long enough for correction to matter.</p>
        </div>
        <div class="card bg-brand-gray-50 p-8 md:p-16 reveal active">
            <div class="w-16 h-16 bg-brand-black flex items-center justify-center text-white mb-10 serif text-3xl font-bold">Q</div>
            <h4 class="text-3xl serif mb-8 text-brand-black font-bold">Quiet self reflection</h4>
            <p class="text-xl text-brand-gray-600 font-light leading-relaxed">Objectively observing angles to self evaluate before reaction in arguments — turning the same tool used on others back on oneself.</p>
        </div>
    </div>
</section>

<!-- BUY CTA -->
<section class="py-24 md:py-32 bg-brand-black text-white text-center overflow-hidden border-t border-white/5">
    <div class="section-container reveal active">
        <h3 class="text-4xl sm:text-5xl md:text-7xl serif mb-10 leading-none font-black tracking-tighter">Acquire Your Copy Now.</h3>
        <p class="text-xl sm:text-2xl md:text-2xl text-white/50 mb-12 font-light leading-relaxed max-w-xl mx-auto italic">Available in print
            and digital formats via Amazon. A foundational text for leaders, thinkers, and strategists.</p>
        <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-invert">Buy on Amazon</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
