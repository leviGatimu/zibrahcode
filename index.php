<?php
/**
 * ZIBRAH CODE™ — Home
 */
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Zibrah Code™ | The Geometry of Truth and Wisdom';
$pageDescription = 'Zibrah Code, by Ibrahim Ngugi, is a geometric model separating truth and perception to reveal how belief, conflict, and leadership decisions evolve.';
$canonicalPath = '/';
$activeNav = 'home';
$ogImage = SITE_URL . '/assets/images/Front page.png';

$extraJsonLd = [
    // Book
    '{"@context":"https://schema.org","@type":"Book","name":"Zibrah Code: The Geometry of Truth and Wisdom","alternateName":"ZibrahCode","author":{"@type":"Person","name":"Ibrahim Ngugi"},"url":"' . SITE_URL . '/","image":"' . SITE_URL . '/assets/images/Front page.png","description":"Zibrah Code introduces a geometric model that separates truth and perception to reveal how belief, conflict, and leadership decisions evolve under pressure.","inLanguage":"en","genre":["Leadership","Philosophy","Strategic Thinking","Conflict Resolution"],"keywords":"Zibrah Code, geometric model, truth and perception, wisdom, leadership, conflict","offers":{"@type":"Offer","availability":"https://schema.org/InStock","url":"' . AMAZON_URL . '","seller":{"@type":"Organization","name":"Amazon"}}}',
    // SiteNavigation
    '{"@context":"https://schema.org","@type":"SiteNavigationElement","name":["Home","The Book","The Framework","Podcast","Blog & Insights","Inquire","The Author","Buy on Amazon"],"url":["' . SITE_URL . '/","' . SITE_URL . '/book.php","' . SITE_URL . '/framework.php","' . SITE_URL . '/podcast.php","' . SITE_URL . '/blog.php","' . SITE_URL . '/inquire.php","' . SITE_URL . '/about.php","' . AMAZON_URL . '"]}',
    // FAQ
    '{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"What is Zibrah Code?","acceptedAnswer":{"@type":"Answer","text":"Zibrah Code (spelled Z-I-B-R-A-H) is an original geometric model created by Ibrahim Ngugi. It separates truth and perception to reveal how belief, conflict, and leadership decisions evolve. It is a book and intellectual framework available on Amazon, and is completely unrelated to Zebra or any animal brand."}},{"@type":"Question","name":"Who is the author of Zibrah Code?","acceptedAnswer":{"@type":"Answer","text":"Zibrah Code was created by Ibrahim Ngugi, an author and audit practitioner with extensive professional experience across East Africa."}},{"@type":"Question","name":"Is Zibrah Code the same as Zebra Code?","acceptedAnswer":{"@type":"Answer","text":"No. Zibrah Code and Zebra Code are completely unrelated. Zibrah Code is spelled Z-I-B-R-A-H and is an original geometric wisdom model by Ibrahim Ngugi about truth, perception, belief, and leadership."}},{"@type":"Question","name":"Where can I buy the Zibrah Code book?","acceptedAnswer":{"@type":"Answer","text":"Zibrah Code: The Geometry of Truth and Wisdom is available on Amazon in both Kindle ebook and print formats."}}]}',
];

require __DIR__ . '/includes/header.php';

$recentPosts = getDb()->query(
    'SELECT title, slug, excerpt, featured_image_path FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT 2'
)->fetchAll();

$latestEpisode = getDb()->query(
    'SELECT title, slug, description, cover_image_path FROM podcast_episodes WHERE status = "published" ORDER BY published_at DESC LIMIT 1'
)->fetch();
?>

<!-- HIDDEN SEO TEXT BLOCK -->
<div class="sr-only" aria-hidden="false">
    <h2>About Zibrah Code</h2>
    <p>
        Zibrah Code — spelled Z-I-B-R-A-H — is an original geometric wisdom framework
        and book by Ibrahim Ngugi. The Zibrah Code is not related to Zebra Code or any
        animal brand. Zibrah Code explores how truth and perception interact through
        geometry to reveal patterns of belief, conflict, and leadership. The full title
        is Zibrah Code: The Geometry of Truth and Wisdom, available on Amazon.
    </p>
</div>

<!-- 1. HERO -->
<header class="section-container lg:min-h-[80vh] flex items-center pt-24 lg:pt-20 relative overflow-hidden">
    <div class="hero-split gap-12 lg:gap-16 w-full relative z-10">
        <div class="active order-2 lg:order-1">
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[9rem] font-display leading-none text-brand-black mb-10 tracking-tighter uppercase font-black">
                Zibrah Code<span class="text-xl align-top ml-2 font-normal opacity-30">™</span>
            </h1>
            <h2 class="text-2xl md:text-2xl lg:text-4xl serif leading-tight text-brand-gray-600 mb-10 font-light italic opacity-90">
                The Geometry of Truth and Wisdom Model
            </h2>
            <p class="text-sm md:text-lg uppercase text-brand-gold mb-12 opacity-90 font-bold">
                Angles show what words cannot tell
            </p>
            <div class="flex flex-col sm:flex-row items-center gap-12">
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener"
                    class="btn-premium w-full sm:w-auto text-center shadow-2xl">Available on Amazon</a>
                <a href="/framework.php" class="text-xs font-black uppercase tracking-[0.4em] border-b-2 border-brand-gray-200 pb-2 hover:border-brand-gold transition-all">Framework</a>
            </div>
        </div>
        <div class="order-1 lg:order-2 flex justify-center items-center active relative h-[380px] sm:h-[460px] lg:h-[650px] w-full mb-6 lg:mb-0 lg:mt-0">
            <div class="absolute transform -translate-x-14 sm:-translate-x-16 lg:-translate-x-24 translate-y-4 sm:translate-y-6 lg:translate-y-8 -rotate-12 opacity-30 transition-all duration-1000">
                <img src="/assets/images/Back page.png" alt="Zibrah Code Back Cover" class="w-48 sm:w-56 lg:w-80 h-auto shadow-2xl">
            </div>
            <div class="relative z-10 max-w-[260px] sm:max-w-[290px] lg:max-w-[380px] transform -rotate-2 hover:rotate-0 transition-all duration-1000 group cursor-pointer shadow-[0_60px_120px_-20px_rgba(0,0,0,0.6)]">
                <img src="/assets/images/Front page.png" alt="Zibrah Code Front Cover — The Geometry of Truth and Wisdom by Ibrahim Ngugi" class="w-full h-auto" fetchpriority="high">
                <div class="absolute inset-0 border-l border-white/20 pointer-events-none"></div>
            </div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border border-brand-gold/10 -z-10 rounded-full scale-105"></div>
        </div>
    </div>
</header>

<!-- 2. CORE STATEMENT -->
<section class="bg-white text-brand-black relative overflow-hidden border-y border-brand-gray-100">
    <div class="absolute inset-0 opacity-5 pointer-events-none flex items-center justify-center">
        <div class="w-[1200px] h-[1200px] border border-brand-gold rounded-full"></div>
    </div>
    <div class="section-container text-center max-w-6xl relative z-10 py-16 md:py-32">
        <h2 class="text-3xl sm:text-4xl md:text-7xl serif text-brand-black leading-tight tracking-tighter font-black">What is Zibrah Code?</h2>
        <p class="text-2xl sm:text-3xl md:text-5xl lg:text-4xl font-sans font-extralight leading-[1.3] tracking-tight px-2 sm:px-6 italic text-brand-black mt-10">
            It's a new way to understand <span class="text-brand-gold font-normal">conflict, belief</span> and
            <span class="text-brand-gold font-normal">leadership.</span> Not through ideology, not through
            <span class="text-brand-gold font-normal">psychology</span> alone. Through
            <span class="text-brand-gold font-normal">geometry.</span>
        </p>
        <hr class="gold-divider my-10 max-w-xs mx-auto">
        <p class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-sans font-extralight leading-[1.3] tracking-tight px-2 sm:px-6 italic text-brand-black">
            It is a structured model that separates truth and perception so their interaction can be examined.
        </p>
    </div>
</section>

<!-- READING THE ANGLE -->
<section class="py-20 md:py-40 bg-white overflow-hidden">
    <div class="section-container">
        <div class="max-w-2xl mx-auto text-center mb-10 md:mb-16">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Reading the Angle</h4>
            <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black leading-tight tracking-tighter font-black">Belief does not collapse suddenly. It closes gradually.</h2>
            <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed mt-8">A wide angle signals openness. A narrow angle signals rigid belief. Neither position is inherently right &mdash; but each is visible, and visibility is the beginning of correction.</p>
        </div>
        <?php require __DIR__ . '/includes/angle-cards.php'; ?>
        <div class="text-center mt-14">
            <a href="/framework.php" class="text-xs font-black uppercase tracking-[0.4em] border-b-2 border-brand-gold pb-2 hover:text-brand-gold transition-all">See How the Model Works &rarr;</a>
        </div>
    </div>
</section>

<!-- FRAMEWORK TEASER (3 of 5 axioms) -->
<section id="framework" class="py-20 md:py-40 pattern-bg border-y border-brand-gray-100 relative overflow-hidden">
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-12 gap-24">
            <div class="lg:col-span-4">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">The Framework</h4>
                <h2 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black italic mb-12">Key <br> Statements.</h2>
                <p class="text-xl text-brand-gray-600 font-light leading-relaxed mb-10">A specialized collection of axiomatic principles that define the Zibrah Code model's structural logic.</p>
                <a href="/framework.php" class="text-xs font-black uppercase tracking-[0.4em] border-b-2 border-brand-gold pb-2 hover:text-brand-gold transition-all">See the Full Framework →</a>
            </div>
            <div class="lg:col-span-8 space-y-16">
                <div class="axiom-item">
                    <span class="text-brand-gold font-black text-xl mb-4 block">01</span>
                    <h3 class="text-2xl md:text-3xl serif text-brand-black font-bold tracking-tight">Truth is a claim.</h3>
                </div>
                <div class="axiom-item">
                    <span class="text-brand-gold font-black text-xl mb-4 block">02</span>
                    <h3 class="text-2xl md:text-3xl serif text-brand-black font-bold tracking-tight">Perception is interpretation.</h3>
                </div>
                <div class="axiom-item">
                    <span class="text-brand-gold font-black text-xl mb-4 block">03</span>
                    <h3 class="text-2xl md:text-3xl serif text-brand-black font-bold tracking-tight">Belief emerges from their interaction.</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT THE BOOK TEASER -->
<section class="py-20 md:py-40 bg-white overflow-hidden">
    <div class="section-container">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-32 items-start">
            <div class="order-2 lg:order-1">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-12">About the Book</h4>
                <h2 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none mb-10 md:mb-16 tracking-tighter uppercase font-black">The Zibrah <br> Code.</h2>
                <div class="space-y-12 text-xl sm:text-2xl md:text-2xl text-brand-gray-600 font-light leading-[1.4] italic md:pr-12">
                    <p>The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                        interact under pressure. By mapping movement between truth and perception, the model reveals
                        why leadership decisions harden, why conflict escalates, and how stability can be restored
                        before breakdown occurs.</p>
                </div>
                <a href="/book.php" class="btn-premium inline-block mt-10">Read More About the Book</a>
            </div>
            <div class="order-1 lg:order-2 flex flex-col justify-center lg:translate-x-16">
                <a href="/book.php" class="flex justify-center items-center sm:h-[600px] lg:h-[820px] w-full group">
                    <img src="/assets/images/book.png" alt="Zibrah Code Book by Ibrahim Ngugi" class="w-full sm:w-[115%] lg:w-[150%] sm:max-w-none h-auto transition-transform duration-1000 group-hover:scale-105" loading="lazy">
                </a>
            </div>
        </div>
    </div>
</section>

<!-- BUY CTA -->
<section class="py-20 md:py-40 bg-brand-black text-white overflow-hidden relative">
    <div class="zebra-wedge absolute" style="width: 260px; height: 260px; top: -60px; right: -60px; clip-path: polygon(30% 0, 100% 0, 100% 70%);"></div>
    <div class="zebra-wedge absolute" style="width: 260px; height: 260px; bottom: -60px; left: -60px; clip-path: polygon(0 30%, 0 100%, 70% 100%);"></div>
    <div class="section-container grid lg:grid-cols-2 gap-10 lg:gap-32 items-center relative z-10">
        <div class="order-2 lg:order-1">
            <h3 class="text-4xl sm:text-5xl md:text-7xl lg:text-[6rem] serif mb-12 leading-none font-black tracking-tighter">
                Acquire <br> Your Copy Now!</h3>
            <p class="text-xl sm:text-2xl md:text-2xl text-white/50 mb-10 md:mb-16 font-light leading-relaxed max-w-xl italic">Available in print
                and digital formats via Amazon. A foundational text for leaders, thinkers, and strategists.</p>
            <div class="flex items-center gap-12">
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener"
                    class="btn-invert">Buy on Amazon</a>
                <button @click="modalBook = true"
                    class="text-[11px] font-bold uppercase tracking-widest border-b border-white/30 pb-1 hover:text-brand-gold hover:border-brand-gold transition-all">Details</button>
            </div>
        </div>
        <div class="order-1 lg:order-2 relative lg:translate-x-24 flex justify-center">
            <img src="/assets/images/goodasset.png" alt="Zibrah Code available in ebook and print, by Ibrahim Ngugi"
                class="w-full sm:w-[120%] lg:w-[160%] sm:max-w-none h-auto" loading="lazy">
        </div>
    </div>
</section>

<!-- AUTHOR TEASER -->
<section id="author" class="py-20 md:py-40 bg-white overflow-hidden">
    <div class="section-container">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-32 items-center">
            <div class="order-2 lg:order-1">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-12">The Author</h4>
                <h2 class="text-4xl sm:text-5xl md:text-[7rem] serif text-brand-black leading-none mb-10 md:mb-16 tracking-tighter uppercase font-black">
                    Ibrahim <br> Ngugi.</h2>
                <div class="space-y-12 text-xl sm:text-2xl text-brand-gray-600 font-light leading-relaxed max-w-xl italic">
                    <p>Ibrahim Ngugi is an author, a facilitator, and an audit practitioner with extensive
                        professional experience auditing complex systems, organizational change dynamics, and
                        professional environments across diverse sectors in East Africa.</p>
                </div>
                <a href="/about.php" class="btn-premium inline-block mt-10">More About Ibrahim</a>
            </div>
            <div class="order-1 lg:order-2 relative flex justify-center items-center">
                <div class="relative z-10 w-full max-w-md bg-white p-8 shadow-2xl border border-brand-gray-100">
                    <div class="aspect-[4/5] overflow-hidden relative group">
                        <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi — Author of Zibrah Code"
                            class="w-full h-full object-cover transition-all duration-[2s]" loading="lazy">
                    </div>
                    <div class="mt-10 text-center">
                        <p class="text-xs font-black uppercase tracking-[0.5em] text-brand-gold">The Author</p>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 border-r border-b border-brand-gold/20 -z-0"></div>
            </div>
        </div>
    </div>
</section>

<!-- PATTERN DIVIDER -->
<div class="pattern-bg pattern-bg-fixed" style="height: 220px;" aria-hidden="true"></div>

<!-- RECENT BLOGS -->
<section class="py-20 md:py-40 bg-brand-gray-50 border-y border-brand-gray-100 overflow-hidden">
    <div class="section-container">
        <div class="max-w-xl mb-12 md:mb-20 text-center mx-auto">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-4">Latest Insights</h4>
            <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black font-black tracking-tight italic">From the Blog.</h2>
        </div>
        <?php if ($recentPosts): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 max-w-4xl mx-auto">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="group">
                        <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="block">
                            <div class="relative aspect-[16/10] bg-brand-gray-100 mb-6 overflow-hidden">
                                <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                            </div>
                            <h3 class="text-2xl serif font-bold text-brand-black mb-3 group-hover:text-brand-gold transition-colors"><?php echo e($post['title']); ?></h3>
                            <p class="text-sm text-brand-gray-600 font-light italic mb-4"><?php echo e($post['excerpt']); ?></p>
                            <span class="text-[10px] font-black uppercase tracking-widest text-brand-gold">Read More</span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="mt-12 md:mt-20 text-center">
            <a href="/blog.php" class="btn-premium">View All Insights</a>
        </div>
    </div>
</section>

<!-- LATEST EPISODE -->
<section class="py-20 md:py-40 bg-white overflow-hidden">
    <div class="section-container">
        <div class="max-w-xl mb-12 md:mb-20 text-center mx-auto">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-4">Listen In</h4>
            <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black font-black tracking-tight italic">The Podcast.</h2>
        </div>
        <?php if ($latestEpisode): ?>
            <div class="max-w-2xl mx-auto card-featured p-12">
                <h3 class="text-3xl serif font-bold text-brand-black mb-4"><?php echo e($latestEpisode['title']); ?></h3>
                <p class="text-lg text-brand-gray-600 font-light mb-6"><?php echo e($latestEpisode['description']); ?></p>
                <a href="/podcast-episode.php?slug=<?php echo e($latestEpisode['slug']); ?>" class="text-[10px] font-black uppercase tracking-widest text-brand-gold">Listen Now →</a>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto empty-state p-8 md:p-16 text-center">
                <p class="text-2xl serif italic text-brand-gray-600 mb-6">New episodes are coming soon.</p>
                <a href="/podcast.php" class="text-[10px] font-black uppercase tracking-widest text-brand-gold">Visit the Podcast Page →</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CONNECT -->
<section id="connect" class="py-20 md:py-40 bg-white border-t border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-3xl mx-auto text-center">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Institutional Correspondence</h4>
            <h2 class="text-5xl sm:text-6xl md:text-8xl serif leading-none mb-10 font-black text-brand-black tracking-tighter">Connect.</h2>
            <p class="text-lg sm:text-xl text-brand-gray-600 mb-10 md:mb-16 font-light max-w-xl mx-auto leading-relaxed italic">
                Join our institutional correspondence for strategic insights on geometric modeling and upcoming publications.</p>
            <form action="/actions/newsletter-subscribe" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left max-w-2xl mx-auto">
                <?php echo csrfField(); ?>
                <?php echo spamGuardFields(); ?>
                <input type="hidden" name="source" value="homepage_form">
                <div class="space-y-3">
                    <label class="text-xs uppercase tracking-[0.3em] text-brand-black font-black">Full Name</label>
                    <input type="text" name="name" placeholder="Ibrahim Ngugi" required class="form-input">
                </div>
                <div class="space-y-3">
                    <label class="text-xs uppercase tracking-[0.3em] text-brand-black font-black">Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required class="form-input">
                </div>
                <div class="md:col-span-2 mt-4">
                    <button type="submit" class="btn-premium w-full py-5 text-sm tracking-[0.4em]">
                        Subscribe to Research Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
