<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'About Ibrahim Ngugi | Zibrah Code™';
$pageDescription = 'Ibrahim Ngugi, author and audit practitioner, created the Zibrah Code — a geometric model for understanding truth, perception, belief, and leadership.';
$canonicalPath = '/about.php';
$activeNav = 'about';
$ogImage = SITE_URL . '/assets/images/auther.jpeg';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"ProfilePage","mainEntity":{"@type":"Person","name":"Ibrahim Ngugi","jobTitle":"Author & Audit Practitioner","image":"' . SITE_URL . '/assets/images/auther.jpeg","sameAs":["' . AMAZON_URL . '","' . YOUTUBE_URL . '","' . X_URL . '"]}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"About","item":"' . SITE_URL . '/about.php"}]}',
];
require __DIR__ . '/includes/header.php';
?>

<!-- FULL-BLEED PHOTO HERO — mobile only -->
<header class="lg:hidden relative h-[65vh] min-h-[440px] w-full overflow-hidden mt-0">
    <img src="/assets/images/auther.jpeg" alt="Ibrahim Ngugi — Author of Zibrah Code"
        class="absolute inset-0 w-full h-full object-cover grayscale" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/50 to-transparent"></div>
    <div class="absolute inset-0 bg-brand-black/20"></div>
    <div class="absolute bottom-0 left-0 right-0 section-container pb-14 reveal active">
        <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">Author &middot; Facilitator &middot; Audit Practitioner</p>
        <h1 class="text-6xl sm:text-7xl font-display font-black text-white uppercase tracking-tighter leading-[0.85]">Ibrahim<br>Ngugi.</h1>
    </div>
</header>

<!-- BOXED PHOTO HEADER — desktop only, sits below the nav, no overlap -->
<div class="hidden lg:block section-container pt-32 pb-16">
    <div class="grid lg:grid-cols-5 gap-16 items-center">
        <div class="lg:col-span-3 reveal active">
            <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">Author &middot; Facilitator &middot; Audit Practitioner</p>
            <h1 class="text-7xl xl:text-8xl font-display font-black text-brand-black uppercase tracking-tighter leading-[0.9]">Ibrahim<br>Ngugi.</h1>
        </div>
        <div class="lg:col-span-2 reveal active">
            <div class="aspect-[4/5] overflow-hidden shadow-2xl">
                <img src="/assets/images/auther.jpeg" alt="Ibrahim Ngugi — Author of Zibrah Code"
                    class="w-full h-full object-cover grayscale" fetchpriority="high">
            </div>
        </div>
    </div>
</div>

<!-- QUOTE + INTRO ASYMMETRIC ROW -->
<section class="py-16 md:py-20 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-2 reveal active">
                <p class="text-3xl md:text-4xl serif italic text-brand-black leading-snug border-l-4 border-brand-gold pl-8">
                    Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.
                </p>
            </div>
            <div class="lg:col-span-3 reveal active">
                <p class="drop-cap text-xl sm:text-2xl md:text-2xl text-brand-gray-700 font-light leading-relaxed">
                    Ibrahim Ngugi spent years inside organizations across East Africa auditing complex systems
                    and organizational change — watching, from the inside, how belief actually moves under
                    pressure rather than how theory says it should. The Zibrah Code is the residue of that
                    observation: a structural way of separating what is true from what is merely believed,
                    built by someone whose day job was finding the gap between what a system claims and what
                    a system actually does.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- STAT STRIP -->
<section class="py-20 bg-brand-black text-white">
    <div class="section-container grid grid-cols-1 sm:grid-cols-3 gap-12 text-center">
        <div class="reveal active">
            <p class="text-5xl md:text-6xl font-display font-black text-brand-gold mb-3">2</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Published Books</p>
        </div>
        <div class="reveal active">
            <p class="text-2xl md:text-3xl font-display font-black text-brand-gold mb-3">East Africa</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Regional Practice</p>
        </div>
        <div class="reveal active">
            <p class="text-2xl md:text-3xl font-display font-black text-brand-gold mb-3">Audit + Narrative</p>
            <p class="text-xs uppercase tracking-[0.3em] text-white/50">Dual Discipline</p>
        </div>
    </div>
</section>

<!-- AUTHOR PORTFOLIO -->
<section class="py-16 md:py-20 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-xl mb-20 text-center mx-auto reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-4">All from the Author.</h4>
            <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black font-black tracking-tight italic">Author's Work.</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 max-w-4xl mx-auto">
            <div class="group">
                <div class="relative">
                    <div class="aspect-[3/4.5] bg-brand-black relative overflow-hidden shadow-2xl flex items-center justify-center p-6 md:p-12 transition-all duration-700 group-hover:scale-[1.03]">
                        <img src="/assets/images/profesional.jpg" alt="The 13th Professional by Ibrahim Ngugi" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 w-full h-2 bg-brand-gold"></div>
                        <div class="absolute inset-0 bg-brand-black/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <a href="https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/" target="_blank" rel="noopener"
                                class="border border-white text-white px-8 py-3 text-[10px] uppercase tracking-widest hover:bg-white hover:text-brand-black transition-all">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <h5 class="text-2xl serif font-bold text-brand-black mb-1">The 13th Professional</h5>
                    <p class="text-sm text-brand-gold uppercase tracking-widest font-semibold mb-2">Values-Based Leadership</p>
                    <p class="text-sm text-brand-gray-600 font-bold italic">Identify, amplify and demystify mindsets.</p>
                </div>
            </div>
            <div class="group">
                <div class="relative">
                    <div class="aspect-[3/4.5] relative overflow-hidden shadow-2xl flex items-center justify-center p-6 md:p-12 transition-all duration-700 group-hover:scale-[1.03] border-4 border-white">
                        <img src="/assets/images/Front page.png" alt="Zibrah Code: The Geometry of Truth and Wisdom" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-brand-black/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <a href="/book.php" class="border border-white text-white px-8 py-3 text-[10px] uppercase tracking-widest hover:bg-white hover:text-brand-black transition-all">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <h5 class="text-2xl serif font-bold text-brand-black mb-1">The Zibrah Code</h5>
                    <p class="text-sm text-brand-gold uppercase tracking-widest font-semibold mb-2">The Geometry of Truth and Wisdom</p>
                    <p class="text-sm text-brand-gray-600 font-bold italic">Angles show what words cannot tell.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-white text-center border-t border-brand-gray-100">
    <div class="section-container reveal active">
        <p class="text-2xl serif italic text-brand-gray-600 mb-10 max-w-xl mx-auto">Want the full framework behind the story?</p>
        <a href="/framework.php" class="btn-premium">Explore the Framework</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
