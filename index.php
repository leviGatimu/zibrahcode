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

$axioms = require __DIR__ . '/includes/axioms.php';

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
        Zibrah Code, spelled Z-I-B-R-A-H, is an original geometric wisdom framework
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
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[8rem] font-display font-bold leading-none text-brand-black mb-10 uppercase">
                <span class="block">Zibrah</span>
                <span class="block">Code<span class="text-xl align-top ml-2 font-normal opacity-30">™</span></span>
            </h1>
            <h2 class="text-2xl md:text-2xl lg:text-4xl serif leading-tight text-brand-gray-600 mb-10 font-light opacity-90">
                The Geometry of Truth and Wisdom Model
            </h2>
            <p class="text-sm md:text-lg uppercase text-brand-gold mb-12 opacity-90 font-bold">
                Angles show what words cannot tell
            </p>
            <div class="flex flex-wrap items-center gap-6">
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Available on Amazon</a>
                <a href="/framework.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Explore the Framework &rarr;</a>
            </div>
        </div>
        <div class="order-1 lg:order-2 flex justify-center items-center active relative h-[300px] sm:h-[460px] lg:h-[650px] w-full mb-2 lg:mb-0 lg:mt-0">
            <div class="absolute transform -translate-x-14 sm:-translate-x-16 lg:-translate-x-24 translate-y-4 sm:translate-y-6 lg:translate-y-8 -rotate-12 opacity-30 transition-all duration-1000">
                <img src="/assets/images/Back page.png" alt="Zibrah Code Back Cover" class="w-40 sm:w-56 lg:w-80 h-auto shadow-2xl">
            </div>
            <div class="relative z-10 max-w-[210px] sm:max-w-[290px] lg:max-w-[380px] transform -rotate-2 hover:rotate-0 transition-all duration-1000 group cursor-pointer shadow-[0_60px_120px_-20px_rgba(0,0,0,0.6)]">
                <img src="/assets/images/Front page.png" alt="Zibrah Code Front Cover: The Geometry of Truth and Wisdom by Ibrahim Ngugi" class="w-full h-auto" fetchpriority="high">
                <div class="absolute inset-0 border-l border-white/20 pointer-events-none"></div>
            </div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border border-brand-gold/10 -z-10 rounded-full scale-105"></div>
        </div>
    </div>
</header>

<!-- 2. WHAT IS ZIBRAH CODE -->
<section class="py-16 md:py-32 bg-brand-gray-50 border-y border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">What is Zibrah Code</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">A new way to understand conflict, belief and leadership.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">Not through ideology, not through psychology alone. Through geometry.</p>
            </div>
            <div class="lg:col-span-3 space-y-8 text-lg sm:text-xl text-brand-gray-700 font-light leading-relaxed reveal active">
                <p>
                    Zibrah Code is a structured model that separates truth and perception so their interaction
                    can be examined. Instead of treating the two as one sliding scale, it holds them apart as
                    independent lines. Belief is what forms in the angle between them.
                </p>
                <p>
                    Once the two are held apart, that angle becomes something that can be seen and measured, not
                    just argued about. It shows why leadership decisions harden, why conflict escalates, and how
                    stability can be restored before breakdown occurs.
                </p>
                <a href="/book.php" class="inline-block text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">About the Book &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- 3. READING THE ANGLE -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="max-w-2xl mb-10 md:mb-16 reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Reading the Angle</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Belief does not collapse suddenly. It closes gradually.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed">A wide angle signals openness. A narrow angle signals rigid belief. Neither position is inherently right, but each is visible, and visibility is the beginning of correction.</p>
        </div>
        <?php require __DIR__ . '/includes/angle-cards.php'; ?>
    </div>
</section>

<!-- 4. THE FIVE AXIOMS -->
<section id="framework" class="py-16 md:py-32 bg-brand-black text-white overflow-hidden relative">
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32 reveal active">
                    <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Framework</h4>
                    <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Five axioms. One geometry.</h2>
                    <p class="text-white/60 font-light leading-relaxed mb-10">Five structural statements define the model&rsquo;s logic. Each one is a move that most arguments skip.</p>
                    <a href="/framework.php" class="btn-invert">Read the Framework</a>
                </div>
            </div>
            <ol class="lg:col-span-8 divide-y divide-white/10">
                <?php foreach ($axioms as $axiom): ?>
                    <li class="py-6 first:pt-0 last:pb-0 reveal active">
                        <a href="/framework.php#axiom-<?php echo e($axiom['number']); ?>" class="group flex sm:grid sm:grid-cols-[5rem_1fr] gap-4 sm:gap-8 items-baseline">
                            <span class="font-display font-black text-2xl sm:text-4xl text-brand-gold leading-none"><?php echo e($axiom['number']); ?></span>
                            <h3 class="serif text-2xl md:text-3xl font-bold text-white tracking-tight group-hover:text-brand-gold transition-colors"><?php echo e($axiom['title']); ?></h3>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- 5. THE BOOK -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <figure class="lg:col-span-6 lg:order-2 reveal active">
                <a href="/book.php" class="block">
                    <img src="/assets/images/book.png" alt="Zibrah Code Book by Ibrahim Ngugi" class="w-full max-w-[300px] lg:max-w-none mx-auto h-auto" loading="lazy">
                </a>
            </figure>
            <div class="lg:col-span-6 lg:order-1 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Book</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">The Geometry of Truth and Wisdom.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-xl mb-10">
                    The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                    interact under pressure. By mapping movement between truth and perception, the model reveals
                    why leadership decisions harden, why conflict escalates, and how stability can be restored
                    before breakdown occurs.
                </p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="/book.php" class="btn-premium">About the Book</a>
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Buy on Amazon &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. GET THE BOOK -->
<section class="py-16 md:py-32 bg-brand-black text-white overflow-hidden">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-6 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Get the Book</h4>
                <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Available now in print and on Kindle.</h2>
                <p class="text-lg text-white/60 font-light leading-relaxed max-w-xl mb-10">A foundational text for leaders, thinkers and strategists. Sold through Amazon in both formats.</p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-invert">Buy on Amazon</a>
                    <a href="/book.php" class="text-xs font-bold uppercase tracking-widest text-white/60 hover:text-brand-gold transition-colors border-b border-white/30 hover:border-brand-gold pb-1">About the Book &rarr;</a>
                </div>
            </div>
            <figure class="lg:col-span-6 reveal active">
                <img src="/assets/images/goodasset.png" alt="Zibrah Code available in ebook and print, by Ibrahim Ngugi" class="w-full h-auto" loading="lazy">
            </figure>
        </div>
    </div>
</section>

<!-- 7. THE AUTHOR -->
<section id="author" class="py-16 md:py-32 bg-brand-gray-50 border-y border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7 lg:order-1 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Author</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Ibrahim Ngugi Gatimu.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-xl mb-10">
                    Author, facilitator and audit practitioner with two decades of experience auditing complex
                    systems, organizational change and professional environments across East and Central Africa.
                    The Zibrah Code is the residue of watching how belief actually moves under pressure.
                </p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="/about.php" class="btn-premium">Meet the Author</a>
                    <a href="/inquire.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Book a Time &rarr;</a>
                </div>
            </div>
            <figure class="lg:col-span-5 lg:order-2 reveal active">
                <div class="bg-white border border-brand-gray-200 p-4 sm:p-6 shadow-2xl max-w-[320px] sm:max-w-[380px] lg:max-w-none mx-auto">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi, Author of Zibrah Code" class="w-full h-full object-cover object-top" loading="lazy">
                    </div>
                </div>
                <figcaption class="text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 mt-4 text-center">Author of The 13th Professional and Zibrah Code&trade;</figcaption>
            </figure>
        </div>
    </div>
</section>

<!-- 8. LATEST: BLOG + PODCAST -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Latest</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">From the blog and the podcast.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md mb-10">Essays and conversations extending the framework into leadership, judgment and conflict.</p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="/blog.php" class="btn-premium">All Insights</a>
                    <a href="/podcast.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">The Podcast &rarr;</a>
                </div>
            </div>
            <div class="lg:col-span-3 reveal active">
                <?php if ($recentPosts): ?>
                    <div class="grid grid-cols-2 gap-4 sm:gap-8">
                        <?php foreach ($recentPosts as $post): ?>
                            <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="group block">
                                <div class="aspect-[16/10] bg-brand-gray-100 mb-5 overflow-hidden">
                                    <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                                </div>
                                <h3 class="serif text-base sm:text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors mb-2"><?php echo e($post['title']); ?></h3>
                                <p class="hidden sm:block text-sm text-brand-gray-600 font-light leading-relaxed"><?php echo e($post['excerpt']); ?></p>
                                <span class="inline-block mt-3 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Read &rarr;</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 mt-12 mb-4">Latest episode</p>
                <?php if ($latestEpisode): ?>
                    <a href="/podcast-episode.php?slug=<?php echo e($latestEpisode['slug']); ?>" class="group block bg-brand-gray-50 border border-brand-gray-200 p-6 sm:p-8 hover:border-brand-black transition-colors">
                        <h3 class="serif text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors"><?php echo e($latestEpisode['title']); ?></h3>
                        <p class="text-sm text-brand-gray-600 font-light leading-relaxed mt-2"><?php echo e($latestEpisode['description']); ?></p>
                        <span class="inline-block mt-4 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Listen &rarr;</span>
                    </a>
                <?php else: ?>
                    <a href="/podcast.php" class="group block bg-brand-gray-50 border border-brand-gray-200 p-6 sm:p-8 hover:border-brand-black transition-colors">
                        <p class="serif text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors">New episodes are coming soon.</p>
                        <span class="inline-block mt-4 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Visit the Podcast &rarr;</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 9. NEWSLETTER -->
<section id="connect" class="py-16 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Newsletter</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">New essays, by email.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">Occasional writing on truth, perception and belief, plus news of upcoming publications. Unsubscribe any time.</p>
            </div>
            <form action="/actions/newsletter-subscribe" method="POST" class="lg:col-span-3 grid sm:grid-cols-2 gap-6 reveal active">
                <?php echo csrfField(); ?>
                <?php echo spamGuardFields(); ?>
                <input type="hidden" name="source" value="homepage_form">
                <div>
                    <label for="home-name" class="block text-xs font-bold uppercase tracking-widest text-brand-black mb-2">Full Name</label>
                    <input id="home-name" type="text" name="name" autocomplete="name" placeholder="Your name" required class="form-input">
                </div>
                <div>
                    <label for="home-email" class="block text-xs font-bold uppercase tracking-widest text-brand-black mb-2">Email Address</label>
                    <input id="home-email" type="email" name="email" autocomplete="email" placeholder="you@example.com" required class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="btn-premium">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
