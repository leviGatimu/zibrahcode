<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'About Ibrahim Ngugi Gatimu | Zibrah Code™';
$pageDescription = 'Ibrahim Ngugi Gatimu — finance professional, author and social entrepreneur with two decades of leadership across East and Central Africa — created the Zibrah Code, a geometric model of truth, perception, belief and leadership.';
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

require __DIR__ . '/includes/header.php';
?>

<!-- FULL-BLEED PHOTO HERO — mobile only -->
<header class="lg:hidden relative h-[65vh] min-h-[440px] w-full overflow-hidden mt-0">
    <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu — Author of Zibrah Code"
        class="absolute inset-0 w-full h-full object-cover object-top" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/50 to-transparent"></div>
    <div class="absolute inset-0 bg-brand-black/20"></div>
    <div class="absolute bottom-0 left-0 right-0 section-container pb-14 reveal active">
        <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">Author &middot; Finance Professional &middot; Social Entrepreneur</p>
        <h1 class="text-6xl sm:text-7xl font-display font-black text-white uppercase tracking-tighter leading-[0.85]">Ibrahim<br>Ngugi.</h1>
        <p class="text-white/60 text-xs uppercase tracking-[0.3em] mt-6">Kigali, Rwanda</p>
    </div>
</header>

<!-- BOXED PHOTO HEADER — desktop only, sits below the nav, no overlap -->
<div class="hidden lg:block section-container pt-28 md:pt-40 pb-16">
    <div class="grid lg:grid-cols-5 gap-16 items-center">
        <div class="lg:col-span-3 reveal active">
            <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">Author &middot; Finance Professional &middot; Social Entrepreneur</p>
            <h1 class="text-7xl xl:text-8xl font-display font-black text-brand-black uppercase tracking-tighter leading-[0.9]">Ibrahim<br>Ngugi<span class="text-brand-gold">.</span></h1>
            <p class="text-xl text-brand-gray-600 font-light leading-relaxed max-w-xl mt-10">
                Finance professional turned author and mentor, helping African leaders and entrepreneurs
                build careers and institutions rooted in unshakeable values.
            </p>
            <div class="flex flex-wrap items-center gap-6 mt-10">
                <a href="/inquire.php" class="btn-premium">Get in Touch</a>
                <a href="<?php echo e(PORTFOLIO_URL); ?>/" target="_blank" rel="noopener" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Full Portfolio &rarr;</a>
            </div>
        </div>
        <div class="lg:col-span-2 reveal active">
            <div class="relative">
                <div class="aspect-[4/5] overflow-hidden shadow-2xl">
                    <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu — Author of Zibrah Code"
                        class="w-full h-full object-cover object-top" fetchpriority="high">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-brand-black text-white px-6 py-4 shadow-xl">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold">Based in</p>
                    <p class="text-sm font-bold uppercase tracking-widest mt-1">Kigali, Rwanda</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BIOGRAPHY + QUICK FACTS -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-3 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Biography</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-10">A legacy of principled leadership.</h2>
                <div class="space-y-8 text-lg sm:text-xl text-brand-gray-700 font-light leading-relaxed">
                    <p class="drop-cap">
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
                        change &mdash; watching, from the inside, how belief actually moves under pressure rather than how
                        theory says it should. The Zibrah Code is the residue of that observation: a structural way of
                        separating what is true from what is merely believed, built by someone whose day job was
                        finding the gap between what a system claims and what it actually does.
                    </p>
                </div>
            </div>

            <aside class="lg:col-span-2 reveal active">
                <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 space-y-8">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-2">Education</p>
                        <p class="serif text-lg font-bold text-brand-black">B.Comm (Finance), First Class Honors</p>
                        <p class="text-sm text-brand-gray-600">JKUAT &amp; Strathmore University</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-2">Author of</p>
                        <p class="serif text-lg font-bold text-brand-black">The 13th Professional &amp; ZIBRAH CODE&trade;</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-2">Core pillars</p>
                        <p class="serif text-lg font-bold text-brand-black">Values-Based Leadership &amp; Entrepreneurial Empowerment</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-3">Affiliated &amp; certified</p>
                        <ul class="flex flex-wrap gap-2">
                            <?php foreach (['JKUAT', 'Strathmore University', 'ICPAK', 'ICPAR', 'SoW!SE Africa'] as $affiliation): ?>
                                <li class="text-[11px] font-bold uppercase tracking-widest text-brand-black bg-white border border-brand-gray-200 px-3 py-2"><?php echo e($affiliation); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <blockquote class="border-l-4 border-brand-gold pl-6 pt-2">
                        <p class="serif italic text-xl text-brand-black leading-snug">&ldquo;Nobody is born a failure.&rdquo;</p>
                        <cite class="not-italic text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 block mt-3">Core philosophy</cite>
                    </blockquote>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- STAT STRIP -->
<section class="py-14 md:py-20 bg-brand-black text-white">
    <div class="section-container grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
        <?php foreach ($stats as $stat): ?>
            <div class="reveal active">
                <p class="text-5xl md:text-6xl font-display font-black text-brand-gold mb-3"><?php echo $stat['value']; ?></p>
                <p class="text-xs uppercase tracking-[0.3em] text-white/50 leading-relaxed"><?php echo $stat['label']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- JOURNEY TIMELINE -->
<section class="py-16 md:py-32 bg-white border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Journey</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Milestones along the way.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">From academic distinction to founding organizations that shape African leadership.</p>
                <a href="<?php echo e(PORTFOLIO_URL); ?>/journey.php" target="_blank" rel="noopener" class="inline-block mt-8 text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Full journey &rarr;</a>
            </div>
            <ol class="lg:col-span-3 border-l border-brand-gray-200 reveal active">
                <?php foreach ($journey as $i => $step): ?>
                    <li class="relative pl-10 <?php echo $i < count($journey) - 1 ? 'pb-12' : ''; ?>">
                        <span class="absolute -left-[5px] top-2 w-[9px] h-[9px] bg-brand-gold" aria-hidden="true"></span>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-2"><?php echo $step['when']; ?></p>
                        <h3 class="serif text-2xl font-bold text-brand-black mb-2"><?php echo $step['title']; ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $step['body']; ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- VENTURES -->
<section class="py-16 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-2xl mb-10 md:mb-16 reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Ventures</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Organizations he has built.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed">Driving the transformation of African leadership across the non-profit and professional sectors.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($ventures as $venture): ?>
                <a href="<?php echo e($venture['href']); ?>" <?php echo $venture['external'] ? 'target="_blank" rel="noopener"' : ''; ?>
                   class="card group bg-white p-10 flex flex-col reveal active">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-6"><?php echo e($venture['kind']); ?></p>
                    <h3 class="serif text-3xl font-black text-brand-black mb-4 group-hover:text-brand-gold transition-colors"><?php echo e($venture['name']); ?></h3>
                    <p class="text-brand-gray-600 font-light leading-relaxed flex-grow"><?php echo $venture['body']; ?></p>
                    <span class="inline-block mt-8 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Explore &rarr;</span>
                </a>
            <?php endforeach; ?>
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

<!-- AUTHOR PORTFOLIO -->
<section class="py-16 md:py-32 bg-brand-gray-50 border-t border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-xl mb-12 md:mb-20 text-center mx-auto reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-4">The Author</h4>
            <h2 class="text-4xl sm:text-5xl md:text-7xl serif text-brand-black font-black tracking-tight italic">Two frameworks.</h2>
            <p class="text-lg text-brand-gray-600 font-light leading-relaxed mt-6">Two decades in the making.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 max-w-4xl mx-auto">
            <div class="group">
                <div class="relative">
                    <div class="aspect-[3/4.5] bg-brand-black relative overflow-hidden shadow-2xl flex items-center justify-center p-6 md:p-12 transition-all duration-700 group-hover:scale-[1.03]">
                        <img src="/assets/images/profesional.jpg" alt="The 13th Professional by Ibrahim Ngugi" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute bottom-0 left-0 w-full h-2 bg-brand-gold"></div>
                        <div class="absolute inset-0 bg-brand-black/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <a href="https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/" target="_blank" rel="noopener"
                                class="border border-white text-white px-8 py-3 text-[10px] uppercase tracking-widest hover:bg-white hover:text-brand-black transition-all">View on Amazon</a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <h5 class="text-2xl serif font-bold text-brand-black mb-1">The 13th Professional</h5>
                    <p class="text-sm text-brand-gold uppercase tracking-widest font-semibold mb-2">Values-Based Leadership</p>
                    <p class="text-sm text-brand-gray-600 font-bold italic">A blueprint for values-based professional excellence.</p>
                </div>
            </div>
            <div class="group">
                <div class="relative">
                    <div class="aspect-[3/4.5] relative overflow-hidden shadow-2xl flex items-center justify-center p-6 md:p-12 transition-all duration-700 group-hover:scale-[1.03] border-4 border-white">
                        <img src="/assets/images/Front page.png" alt="Zibrah Code: The Geometry of Truth and Wisdom" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
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
<section class="py-16 md:py-24 bg-white text-center border-t border-brand-gray-100">
    <div class="section-container reveal active">
        <p class="text-3xl md:text-4xl serif italic text-brand-black leading-snug max-w-2xl mx-auto mb-4">Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.</p>
        <p class="text-[10px] uppercase tracking-[0.3em] text-brand-gold mb-12">Ibrahim Ngugi Gatimu</p>
        <div class="flex flex-wrap justify-center items-center gap-6">
            <a href="/framework.php" class="btn-premium">Explore the Framework</a>
            <a href="<?php echo e(PORTFOLIO_URL); ?>/" target="_blank" rel="noopener" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Visit ibrahim.zibrahcode.com &rarr;</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
