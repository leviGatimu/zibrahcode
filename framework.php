<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'The Zibrah Code Framework | Axioms of Truth & Perception';
$pageDescription = 'The five axiomatic principles of the Zibrah Code — the structural logic behind how truth, perception, belief, and wisdom interact under pressure.';
$canonicalPath = '/framework.php';
$activeNav = 'framework';
$ogImage = SITE_URL . '/assets/images/blog.png';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"The Framework","item":"' . SITE_URL . '/framework.php"}]}',
];

$axioms = require __DIR__ . '/includes/axioms.php';

$applications = [
    ['title' => 'Leadership', 'body' => 'Why decisions harden under pressure &mdash; and how to keep options open long enough for correction to matter.'],
    ['title' => 'Conflict &amp; Mediation', 'body' => 'A side-neutral way to read a dispute: the geometry is visible before anyone has to be declared right.'],
    ['title' => 'Self-reflection', 'body' => 'The same tool turned inward: observing your own angle before you react, and noticing when it has stopped rotating.'],
];

$furtherReading = [
    ['slug' => 'zibrah-code-foundational-structure', 'title' => 'Zibrah Code Foundational Structure', 'blurb' => 'The two independent lines &mdash; and why the angle between them is where belief lives.'],
    ['slug' => 'angles-show-what-words-cannot-tell', 'title' => 'Angles Show What Words Cannot Tell', 'blurb' => 'How belief moves, narrows and locks &mdash; and why arguments rarely interrupt the pattern.'],
];

require __DIR__ . '/includes/header.php';
?>

<!-- HERO: the model itself -->
<header class="bg-brand-gray-50 border-b border-brand-gray-100 overflow-hidden">
    <div class="section-container pt-24 lg:pt-40 pb-16 lg:pb-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-6 reveal active">
                <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Framework</p>
                <h1 class="text-5xl sm:text-6xl xl:text-7xl serif text-brand-black leading-none tracking-tighter font-black">The geometry of truth and wisdom.</h1>
                <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed mt-8 max-w-xl">
                    Two independent lines &mdash; truth and perception &mdash; set at an angle to each other, not stacked,
                    not merged. Belief is what forms in the angle between them. Once the two are held apart, that
                    angle becomes something that can be seen and measured, not just argued about.
                </p>
                <div class="flex flex-wrap items-center gap-6 mt-10">
                    <a href="#axioms" class="btn-premium">The Five Axioms</a>
                    <a href="/book.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Read the Book &rarr;</a>
                </div>
            </div>
            <figure class="lg:col-span-6 reveal active">
                <div class="bg-white border border-brand-gray-200 p-4 sm:p-6 shadow-2xl">
                    <img src="/assets/images/blog.png" alt="Zibrah Code diagram: a Truth axis and a Perception axis with the unit square of truth, projection lines and grounding lines" class="w-full h-auto" fetchpriority="high">
                </div>
                <figcaption class="text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 mt-4 text-center">The model &middot; truth axis, perception axis, and the angle between them</figcaption>
            </figure>
        </div>
    </div>
</header>

<!-- READING THE ANGLE -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="max-w-2xl mb-10 md:mb-16 reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Reading the Angle</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Belief does not collapse suddenly. It closes gradually.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed">A wide angle signals openness. A narrow angle signals rigid belief. Neither position is inherently right &mdash; but each is visible, and visibility is the beginning of correction.</p>
        </div>
        <?php require __DIR__ . '/includes/angle-cards.php'; ?>
    </div>
</section>

<!-- THE FIVE AXIOMS -->
<section id="axioms" class="py-16 md:py-32 bg-brand-black text-white overflow-hidden relative scroll-mt-24">
    <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] border border-white/5 rounded-full pointer-events-none" aria-hidden="true"></div>
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32 reveal active">
                    <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Key Statements</h4>
                    <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Five axioms, in order.</h2>
                    <p class="text-white/60 font-light leading-relaxed mb-10">Each statement is a structural move that most arguments skip. Together they define the model&rsquo;s logic.</p>
                    <ol class="hidden lg:block space-y-3 border-l border-white/10">
                        <?php foreach ($axioms as $axiom): ?>
                            <li>
                                <a href="#axiom-<?php echo e($axiom['number']); ?>" class="flex items-baseline gap-4 pl-6 -ml-px border-l-2 border-transparent hover:border-brand-gold text-white/50 hover:text-white transition-colors">
                                    <span class="font-display font-black text-brand-gold text-sm"><?php echo e($axiom['number']); ?></span>
                                    <span class="text-sm"><?php echo e($axiom['title']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
            <ol class="lg:col-span-8 divide-y divide-white/10">
                <?php foreach ($axioms as $axiom): ?>
                    <li id="axiom-<?php echo e($axiom['number']); ?>" class="py-10 first:pt-0 last:pb-0 scroll-mt-32 reveal active">
                        <div class="grid sm:grid-cols-[5rem_1fr] gap-4 sm:gap-8">
                            <span class="font-display font-black text-5xl text-brand-gold leading-none"><?php echo e($axiom['number']); ?></span>
                            <div>
                                <h3 class="serif text-3xl md:text-4xl font-bold text-white tracking-tight mb-4"><?php echo e($axiom['title']); ?></h3>
                                <p class="text-lg text-white/60 font-light leading-relaxed"><?php echo e($axiom['body']); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- WHERE IT APPLIES -->
<section class="py-16 md:py-32 bg-white border-b border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Where It Applies</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">The same geometry, at every scale.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">The patterns are consistent across individuals, groups, institutions and societies. The question shifts from <em>who is wrong</em> to <em>what stage has been reached</em>.</p>
            </div>
            <div class="lg:col-span-3 grid sm:grid-cols-3 gap-x-10 gap-y-10 reveal active">
                <?php foreach ($applications as $i => $item): ?>
                    <div class="axiom-item">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-3"><?php echo sprintf('%02d', $i + 1); ?></p>
                        <h3 class="serif text-2xl font-bold text-brand-black mb-3"><?php echo $item['title']; ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $item['body']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- FURTHER READING + CTA -->
<section class="py-16 md:py-32 bg-brand-gray-50">
    <div class="section-container">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div class="reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Go Deeper</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">The full treatment is in the book.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md mb-10">The axioms above are the skeleton. The book works through how belief forms, how extremes mirror each other, and how wisdom differs from projection.</p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="/book.php" class="btn-premium">About the Book</a>
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Buy on Amazon &rarr;</a>
                </div>
            </div>
            <div class="reveal active">
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 mb-4">From the blog</p>
                <div class="space-y-4">
                    <?php foreach ($furtherReading as $post): ?>
                        <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="group block bg-white border border-brand-gray-200 p-6 hover:border-brand-black transition-colors">
                            <p class="serif text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors"><?php echo e($post['title']); ?></p>
                            <p class="text-sm text-brand-gray-600 font-light leading-relaxed mt-2"><?php echo $post['blurb']; ?></p>
                            <span class="inline-block mt-4 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Read &rarr;</span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <a href="/podcast.php" class="inline-block mt-6 text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Listen to the Podcast &rarr;</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
