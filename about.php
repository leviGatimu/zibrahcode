<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'About Ibrahim Ngugi Gatimu | Zibrah Code™';
$pageDescription = 'Ibrahim Ngugi Gatimu, a finance professional, author and social entrepreneur with two decades of leadership across East and Central Africa, created the Zibrah Code, a geometric model of truth, perception, belief and leadership.';
$canonicalPath = '/about.php';
$activeNav = 'about';
$ogImage = SITE_URL . '/assets/images/auther.jpeg';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"ProfilePage","mainEntity":{"@type":"Person","name":"Ibrahim Ngugi Gatimu","alternateName":"Ibrahim Ngugi","jobTitle":"Author, Finance Professional & Social Entrepreneur","image":"' . SITE_URL . '/assets/images/auther.jpeg","url":"' . PORTFOLIO_URL . '/","homeLocation":{"@type":"Place","name":"Kigali, Rwanda"},"alumniOf":[{"@type":"CollegeOrUniversity","name":"Jomo Kenyatta University of Agriculture and Technology"},{"@type":"CollegeOrUniversity","name":"Strathmore University"}],"sameAs":["' . PORTFOLIO_URL . '/","' . AMAZON_URL . '","' . YOUTUBE_URL . '","' . X_URL . '"]}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"The Author","item":"' . SITE_URL . '/about.php"}]}',
];

// Content below mirrors Ibrahim's portfolio site (PORTFOLIO_URL) so the two stay in step.
$stats = [
    ['value' => '20+', 'label' => 'Years of Experience'],
    ['value' => '10K+', 'label' => 'Leaders Trained'],
    ['value' => '8', 'label' => 'Countries across East &amp; Central Africa'],
    ['value' => '2', 'label' => 'Published Books'],
];

$journey = [
    ['when' => 'Education', 'title' => 'First Class Honors, B.Comm (Finance)', 'body' => 'JKUAT &amp; Strathmore University.'],
    ['when' => '2012', 'title' => 'Founded GNI CPA Ltd', 'body' => 'Certified audit, tax and institutional governance consultancy in Rwanda.'],
    ['when' => 'Venture', 'title' => 'Founded SoW!SE Africa', 'body' => 'NGO for values-based leadership and youth entrepreneurship, Kigali, Rwanda.'],
    ['when' => 'Book', 'title' => 'Published The 13th Professional', 'body' => 'A blueprint for values-based professional excellence.'],
    ['when' => 'Book', 'title' => 'Published ZIBRAH CODE&trade;', 'body' => 'The Geometry of Truth and Wisdom Model.'],
];

$ventures = [
    ['kind' => 'NGO / Education', 'name' => 'SoW!SE Africa', 'body' => 'Empowering the next generation of African leaders through values-based transformation and practical skills. Home of the Let&rsquo;s Talk Dialogue-Unlimited (LTD-U) mentorship program.', 'href' => 'https://www.sowiseafrica.org/', 'external' => true],
    ['kind' => 'Consultancy', 'name' => 'GNI CPA Ltd', 'body' => 'Certified professional services firm providing audit, tax and institutional governance consulting.', 'href' => PORTFOLIO_URL . '/gni.php', 'external' => true],
    ['kind' => 'Framework', 'name' => 'Zibrah Code', 'body' => 'A new way to understand conflict, belief and leadership. Not through ideology, not through psychology alone. Through geometry.', 'href' => '/framework.php', 'external' => false],
];

$engagements = [
    ['title' => 'Leadership Consulting', 'body' => 'Advising organizations on values-based leadership systems, institutional governance and human capital strategy.'],
    ['title' => 'Keynote Speaking', 'body' => 'Conferences, universities and corporate events on professional excellence, ethics and African leadership.'],
    ['title' => 'Financial Advisory &amp; Audit', 'body' => 'Certified audit, tax and institutional governance consulting through GNI CPA Ltd.'],
    ['title' => 'Youth Mentorship', 'body' => 'Guiding young professionals and entrepreneurs through the LTD-U dialogue-based mentorship framework.'],
];

$books = [
    ['title' => 'The 13th Professional', 'kind' => 'Values-Based Leadership', 'sub' => 'A blueprint for values-based professional excellence.', 'image' => '/assets/images/profesional.jpg', 'href' => 'https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/', 'external' => true, 'cta' => 'View on Amazon'],
    ['title' => 'Zibrah Code', 'kind' => 'The Geometry of Truth and Wisdom', 'sub' => 'A geometric model of truth, perception, belief and leadership.', 'image' => '/assets/images/Front page.png', 'href' => '/book.php', 'external' => false, 'cta' => 'About the Book'],
];

require __DIR__ . '/includes/header.php';
?>

<!-- PAGE HEADER: the author -->
<header class="bg-brand-gray-50 border-b border-brand-gray-100 overflow-hidden">
    <div class="section-container pt-24 lg:pt-40 pb-16 lg:pb-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7 reveal active">
                <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Author</p>
                <h1 class="text-5xl sm:text-6xl xl:text-7xl serif text-brand-black leading-none tracking-tighter font-black">Ibrahim Ngugi Gatimu.</h1>
                <p class="text-sm text-brand-gray-500 mt-6">Author &middot; Finance Professional &middot; Social Entrepreneur &middot; Kigali, Rwanda</p>
                <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed mt-8 max-w-xl">
                    Finance professional turned author and mentor, helping African leaders and entrepreneurs
                    build careers and institutions rooted in unshakeable values.
                </p>
                <div class="flex flex-wrap items-center gap-6 mt-10">
                    <a href="/inquire.php" class="btn-premium">Get in Touch</a>
                    <a href="<?php echo e(PORTFOLIO_URL); ?>/" target="_blank" rel="noopener" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Full Portfolio &rarr;</a>
                </div>
            </div>
            <figure class="lg:col-span-5 reveal active">
                <div class="bg-white border border-brand-gray-200 p-4 sm:p-6 shadow-2xl max-w-[320px] sm:max-w-[380px] lg:max-w-none mx-auto">
                    <div class="aspect-[4/5] overflow-hidden">
                        <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu, Author of Zibrah Code" class="w-full h-full object-cover object-top" fetchpriority="high">
                    </div>
                </div>
                <figcaption class="text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 mt-4 text-center">Author of The 13th Professional and Zibrah Code&trade;</figcaption>
            </figure>
        </div>
    </div>
</header>

<!-- BIOGRAPHY -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Biography</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">A legacy of principled leadership.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md mb-8">Two decades inside organizations, bridging professional excellence and personal values.</p>
                <dl class="border-t border-brand-gray-200 max-w-md">
                    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
                        <dt class="text-brand-gray-500">Education</dt>
                        <dd class="text-brand-black">B.Comm (Finance), First Class Honors<br><span class="text-brand-gray-500">JKUAT &amp; Strathmore University</span></dd>
                    </div>
                    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
                        <dt class="text-brand-gray-500">Affiliations</dt>
                        <dd class="text-brand-black">JKUAT &middot; Strathmore University &middot; ICPAK &middot; ICPAR &middot; SoW!SE Africa</dd>
                    </div>
                    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
                        <dt class="text-brand-gray-500">Based in</dt>
                        <dd class="text-brand-black">Kigali, Rwanda</dd>
                    </div>
                </dl>
            </div>
            <div class="lg:col-span-3 space-y-8 text-lg sm:text-xl text-brand-gray-700 font-light leading-relaxed reveal active">
                <p>
                    Ibrahim Ngugi Gatimu is a finance professional, author and social entrepreneur with over two
                    decades of leadership experience across East and Central Africa, including Ethiopia and the
                    DR Congo. A graduate of Strathmore University and holder of a First Class Honors degree from
                    JKUAT, he has dedicated his career to bridging the gap between professional excellence and
                    unshakeable personal values.
                </p>
                <p>
                    Driven by the conviction that <em>&ldquo;nobody is born a failure,&rdquo;</em> he founded SoW!SE Africa to
                    shift paradigms from job-seeking to job-creating. Through its Let&rsquo;s Talk Dialogue-Unlimited
                    (LTD-U) program, he helps African youth reconcile with their talents and lead with integrity.
                </p>
                <p>
                    Those same years were spent inside organizations auditing complex systems and organizational
                    change, watching, from the inside, how belief actually moves under pressure rather than how
                    theory says it should. The Zibrah Code is the residue of that observation: a structural way of
                    separating what is true from what is merely believed, built by someone whose day job was
                    finding the gap between what a system claims and what it actually does.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- IN NUMBERS -->
<section class="py-14 md:py-24 bg-brand-black text-white">
    <div class="section-container">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
            <?php foreach ($stats as $stat): ?>
                <div class="reveal active">
                    <p class="text-5xl md:text-6xl font-display font-black text-brand-gold mb-3"><?php echo $stat['value']; ?></p>
                    <p class="text-xs uppercase tracking-[0.3em] text-white/50 leading-relaxed"><?php echo $stat['label']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- JOURNEY TIMELINE -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Journey</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Milestones along the way.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">From academic distinction to founding organizations that shape African leadership.</p>
                <a href="<?php echo e(PORTFOLIO_URL); ?>/journey.php" target="_blank" rel="noopener" class="inline-block mt-8 text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Full Journey &rarr;</a>
            </div>
            <ol class="lg:col-span-3 divide-y divide-brand-gray-100 reveal active">
                <?php foreach ($journey as $step): ?>
                    <li class="grid sm:grid-cols-[7rem_1fr] gap-x-8 gap-y-2 py-6 first:pt-0 last:pb-0">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold pt-2"><?php echo $step['when']; ?></p>
                        <div>
                            <h3 class="serif text-2xl font-bold text-brand-black mb-2"><?php echo $step['title']; ?></h3>
                            <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $step['body']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- VENTURES -->
<section class="py-16 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Ventures</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Organizations he has built.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">Driving the transformation of African leadership across the non-profit and professional sectors.</p>
            </div>
            <div class="lg:col-span-3 grid sm:grid-cols-3 gap-x-10 gap-y-10 reveal active">
                <?php foreach ($ventures as $venture): ?>
                    <div class="axiom-item">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-3"><?php echo e($venture['kind']); ?></p>
                        <h3 class="serif text-2xl font-bold text-brand-black mb-3">
                            <a href="<?php echo e($venture['href']); ?>" <?php echo $venture['external'] ? 'target="_blank" rel="noopener"' : ''; ?> class="hover:text-brand-gold transition-colors"><?php echo e($venture['name']); ?></a>
                        </h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $venture['body']; ?></p>
                        <a href="<?php echo e($venture['href']); ?>" <?php echo $venture['external'] ? 'target="_blank" rel="noopener"' : ''; ?> class="inline-block mt-4 text-xs font-bold uppercase tracking-widest text-brand-black hover:text-brand-gold transition-colors">Explore &rarr;</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- AREAS OF ENGAGEMENT -->
<section class="py-16 md:py-32 bg-white border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Expertise</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Areas of engagement.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md mb-10">Available for leadership consulting, speaking, financial advisory and mentorship.</p>
                <a href="/inquire.php" class="btn-premium">Book a Time</a>
            </div>
            <div class="lg:col-span-3 grid sm:grid-cols-2 gap-x-12 gap-y-10 reveal active">
                <?php foreach ($engagements as $i => $item): ?>
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

<!-- BOOKS -->
<section class="py-16 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Books</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Two frameworks. Two decades in the making.</h2>
                <blockquote class="border-l-4 border-brand-gold pl-6 mt-10 max-w-md">
                    <p class="text-xl text-brand-black font-light leading-snug">&ldquo;Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.&rdquo;</p>
                    <cite class="not-italic text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 block mt-3">Ibrahim Ngugi Gatimu</cite>
                </blockquote>
            </div>
            <div class="lg:col-span-3 grid sm:grid-cols-2 gap-8 reveal active">
                <?php foreach ($books as $book): ?>
                    <a href="<?php echo e($book['href']); ?>" <?php echo $book['external'] ? 'target="_blank" rel="noopener"' : ''; ?> class="group bg-white border border-brand-gray-200 p-8 hover:border-brand-black transition-colors flex flex-col">
                        <img src="<?php echo e($book['image']); ?>" alt="<?php echo e($book['title']); ?> cover" class="w-28 h-auto shadow-lg mb-8" loading="lazy">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-3"><?php echo e($book['kind']); ?></p>
                        <h3 class="serif text-2xl font-bold text-brand-black group-hover:text-brand-gold transition-colors mb-2"><?php echo e($book['title']); ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed flex-grow"><?php echo e($book['sub']); ?></p>
                        <span class="inline-block mt-6 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors"><?php echo e($book['cta']); ?> &rarr;</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
