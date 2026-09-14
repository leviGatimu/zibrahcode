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
    'SELECT title, slug, excerpt, featured_image_path FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT 3'
)->fetchAll();

$latestEpisode = getDb()->query(
    'SELECT title, slug, description, cover_image_path FROM podcast_episodes WHERE status = "published" ORDER BY published_at DESC LIMIT 1'
)->fetch();

$axioms = require __DIR__ . '/includes/axioms.php';
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

<!-- Every section below follows one system: eyebrow (gold, tracked caps) →
     heading (serif, 4xl/5xl) → body (light gray) → CTA. Backgrounds alternate
     white / gray-50 / black so section boundaries read without extra dividers. -->

<!-- 1. HERO -->
<header class="section-container lg:min-h-[80vh] flex items-center pt-24 lg:pt-20 pb-12 lg:pb-0 relative overflow-hidden">
    <div class="hero-split gap-12 lg:gap-16 w-full relative z-10">
        <div class="order-2 lg:order-1">
            <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Geometry of Truth and Wisdom Model</p>
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[9rem] font-display leading-none text-brand-black mb-8 tracking-tighter uppercase font-black">
                Zibrah Code<span class="text-xl align-top ml-2 font-normal opacity-30">™</span>
            </h1>
            <p class="text-xl sm:text-2xl serif italic text-brand-gray-700 leading-snug mb-10 max-w-xl mx-auto lg:mx-0">
                A new way to understand conflict, belief and leadership. Not through ideology,
                not through psychology alone. Through geometry.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 sm:gap-10">
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener"
                    class="btn-premium w-full sm:w-auto text-center">Available on Amazon</a>
                <a href="/framework.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Explore the Framework &rarr;</a>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-gold/70 mt-10">Angles show what words cannot tell</p>
        </div>
        <div class="order-1 lg:order-2 flex justify-center items-center relative h-[380px] sm:h-[460px] lg:h-[650px] w-full">
            <div class="absolute transform -translate-x-14 sm:-translate-x-16 lg:-translate-x-24 translate-y-4 sm:translate-y-6 lg:translate-y-8 -rotate-12 opacity-30">
                <img src="/assets/images/Back page.png" alt="" aria-hidden="true" class="w-48 sm:w-56 lg:w-80 h-auto shadow-2xl">
            </div>
            <div class="relative z-10 max-w-[260px] sm:max-w-[290px] lg:max-w-[380px] transform -rotate-2 hover:rotate-0 transition-transform duration-700 shadow-[0_60px_120px_-20px_rgba(0,0,0,0.6)]">
                <img src="/assets/images/Front page.png" alt="Zibrah Code Front Cover — The Geometry of Truth and Wisdom by Ibrahim Ngugi" class="w-full h-auto" fetchpriority="high">
            </div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border border-brand-gold/10 -z-10 rounded-full" aria-hidden="true"></div>
        </div>
    </div>
</header>

<!-- 2. THE IDEA -->
<section class="py-20 md:py-32 bg-brand-gray-50 border-y border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-3xl mx-auto text-center">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Idea</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-8">What is Zibrah Code?</h2>
            <p class="text-2xl sm:text-3xl serif italic text-brand-black leading-snug mb-8">
                Truth and perception are two independent lines. Belief is what forms in the
                <span class="text-brand-gold">angle</span> between them.
            </p>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-2xl mx-auto">
                It is a structured model that separates truth and perception so their interaction can be examined
                &mdash; why leadership decisions harden, why conflict escalates, and how stability can be restored
                before breakdown occurs.
            </p>
        </div>
    </div>
</section>

<!-- 3. THE FRAMEWORK -->
<section class="py-20 md:py-32 bg-brand-black text-white overflow-hidden relative">
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] border border-white/5 rounded-full pointer-events-none" aria-hidden="true"></div>
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
            <div class="lg:col-span-4">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Framework</h4>
                <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Five axioms, in order.</h2>
                <p class="text-lg text-white/60 font-light leading-relaxed mb-10">Each statement is a structural move that most arguments skip. Together they define the model&rsquo;s logic.</p>
                <a href="/framework.php" class="btn-invert">See the Full Framework</a>
            </div>
            <ol class="lg:col-span-8 grid sm:grid-cols-2 gap-x-10 gap-y-8">
                <?php foreach ($axioms as $axiom): ?>
                    <li class="border-t border-white/10 pt-6">
                        <span class="font-display font-black text-2xl text-brand-gold leading-none block mb-3"><?php echo e($axiom['number']); ?></span>
                        <h3 class="serif text-2xl font-bold text-white tracking-tight"><?php echo e($axiom['title']); ?></h3>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- 4. THE BOOK -->
<section class="py-20 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-5">
                <a href="/book.php" class="block relative max-w-[280px] sm:max-w-[340px] mx-auto group">
                    <div class="absolute -inset-6 border border-brand-gold/20 pointer-events-none" aria-hidden="true"></div>
                    <img src="/assets/images/Front page.png" alt="Zibrah Code — front cover" class="relative w-full h-auto shadow-[0_40px_80px_-20px_rgba(0,0,0,0.45)] transition-transform duration-700 group-hover:-translate-y-1" loading="lazy">
                </a>
            </div>
            <div class="lg:col-span-7">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Book</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">The Zibrah Code.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-6">
                    The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                    interact under pressure. By mapping movement between truth and perception, the model reveals
                    why leadership decisions harden, why conflict escalates, and how stability can be restored
                    before breakdown occurs.
                </p>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-10">
                    Available in Kindle and print. A foundational text for leaders, thinkers, and strategists.
                </p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
                    <a href="/book.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">About the Book &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. THE AUTHOR -->
<section class="py-20 md:py-32 bg-brand-gray-50 border-y border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7 order-2 lg:order-1">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Author</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Ibrahim Ngugi Gatimu.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-6">
                    Finance professional, author and social entrepreneur with over two decades of leadership
                    experience across East and Central Africa. Years spent auditing complex systems and
                    organizational change &mdash; watching how belief actually moves under pressure &mdash; became
                    the Zibrah Code.
                </p>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-10">
                    Founder of SoW!SE Africa and GNI CPA Ltd. Author of <em>The 13th Professional</em> and
                    <em>ZIBRAH CODE&trade;</em>.
                </p>
                <a href="/about.php" class="btn-premium">Meet the Author</a>
            </div>
            <div class="lg:col-span-5 order-1 lg:order-2">
                <div class="relative max-w-sm mx-auto">
                    <div class="aspect-[4/5] overflow-hidden shadow-2xl">
                        <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu — Author of Zibrah Code"
                            class="w-full h-full object-cover object-top" loading="lazy">
                    </div>
                    <div class="absolute -bottom-5 -left-5 bg-brand-black text-white px-5 py-3 shadow-xl">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold">Based in</p>
                        <p class="text-sm font-bold uppercase tracking-widest mt-1">Kigali, Rwanda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. READING THE ANGLE -->
<section class="py-20 md:py-32 bg-white">
    <div class="section-container">
        <div class="max-w-2xl mb-12 md:mb-16">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Reading the Angle</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Belief does not collapse suddenly. It closes gradually.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed">A wide angle signals openness. A narrow angle signals rigid belief. Neither position is inherently right &mdash; but each is visible, and visibility is the beginning of correction.</p>
        </div>
        <?php require __DIR__ . '/includes/angle-cards.php'; ?>
    </div>
</section>

<!-- 7. FROM THE BLOG -->
<section class="py-20 md:py-32 bg-brand-gray-50 border-y border-brand-gray-100">
    <div class="section-container">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-12 md:mb-16">
            <div class="max-w-2xl">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Latest Insights</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight">From the blog.</h2>
            </div>
            <a href="/blog.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1 self-start sm:self-auto">All posts &rarr;</a>
        </div>
        <?php if ($recentPosts): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <?php foreach ($recentPosts as $post): ?>
                    <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="group block">
                        <div class="relative aspect-[16/10] bg-brand-gray-100 mb-6 overflow-hidden">
                            <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                        </div>
                        <h3 class="text-2xl serif font-bold text-brand-black leading-snug mb-3 group-hover:text-brand-gold transition-colors"><?php echo e($post['title']); ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed mb-4"><?php echo e(excerptText($post['excerpt'] ?? '', 120)); ?></p>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Read &rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state p-10 text-center">
                <p class="text-xl serif italic text-brand-gray-600">First articles are on their way.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- 8. THE PODCAST -->
<section class="py-20 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-5">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Podcast</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Listen in.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-10">Conversations on truth, perception, belief and leadership &mdash; extending the Zibrah Code framework into voice.</p>
                <a href="/podcast.php" class="btn-premium">Go to the Podcast</a>
            </div>
            <div class="lg:col-span-7">
                <?php if ($latestEpisode): ?>
                    <a href="/podcast-episode.php?slug=<?php echo e($latestEpisode['slug']); ?>" class="group card-featured bg-white p-8 md:p-10 block">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-4">Latest episode</p>
                        <h3 class="text-2xl sm:text-3xl serif font-bold text-brand-black leading-snug mb-4 group-hover:text-brand-gold transition-colors"><?php echo e($latestEpisode['title']); ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed mb-6"><?php echo e(excerptText($latestEpisode['description'] ?? '', 180)); ?></p>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Listen now &rarr;</span>
                    </a>
                <?php else: ?>
                    <div class="empty-state p-8 md:p-12">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-4">Coming soon</p>
                        <p class="text-2xl serif italic text-brand-black leading-snug mb-4">New episodes are on their way.</p>
                        <p class="text-brand-gray-600 font-light leading-relaxed">Subscribe below and we&rsquo;ll let you know the moment the first episode is live.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 9. CONNECT -->
<section id="connect" class="py-20 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-2xl mx-auto text-center">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Stay in Touch</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Research updates.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed mb-10">
                New articles, episodes and publications &mdash; occasionally, and only when there is something worth reading.
            </p>
            <form action="/actions/newsletter-subscribe" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <?php echo csrfField(); ?>
                <?php echo spamGuardFields(); ?>
                <input type="hidden" name="source" value="homepage_form">
                <div class="space-y-3">
                    <label for="home-name" class="text-xs uppercase tracking-[0.3em] text-brand-black font-black">Full Name</label>
                    <input type="text" name="name" id="home-name" placeholder="Your name" required class="form-input">
                </div>
                <div class="space-y-3">
                    <label for="home-email" class="text-xs uppercase tracking-[0.3em] text-brand-black font-black">Email Address</label>
                    <input type="email" name="email" id="home-email" placeholder="you@example.com" required class="form-input">
                </div>
                <div class="md:col-span-2 mt-2">
                    <button type="submit" class="btn-premium w-full py-5 text-sm tracking-[0.4em]">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
