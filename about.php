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
    ['title' => 'The 13th Professional', 'sub' => 'A blueprint for values-based professional excellence.', 'image' => '/assets/images/profesional.jpg', 'href' => 'https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/', 'external' => true],
    ['title' => 'Zibrah Code', 'sub' => 'The Geometry of Truth and Wisdom Model in Leadership, Judgment, and Conflict.', 'image' => '/assets/images/Front page.png', 'href' => '/book.php', 'external' => false],
];

// Facts are rendered once and placed twice: under the portrait on desktop,
// at the end of the page on phones (so the name follows the portrait there).
ob_start();
?>
<dl class="border-t border-brand-gray-200">
    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
        <dt class="text-brand-gray-500">Based in</dt>
        <dd class="text-brand-black">Kigali, Rwanda</dd>
    </div>
    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
        <dt class="text-brand-gray-500">Education</dt>
        <dd class="text-brand-black">B.Comm (Finance), First Class Honors<br><span class="text-brand-gray-500">JKUAT &amp; Strathmore University</span></dd>
    </div>
    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
        <dt class="text-brand-gray-500">Author of</dt>
        <dd class="text-brand-black">The 13th Professional<br>Zibrah Code&trade;</dd>
    </div>
    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
        <dt class="text-brand-gray-500">Affiliations</dt>
        <dd class="text-brand-black">JKUAT &middot; Strathmore University &middot; ICPAK &middot; ICPAR &middot; SoW!SE Africa</dd>
    </div>
    <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
        <dt class="text-brand-gray-500">Portfolio</dt>
        <dd><a href="<?php echo e(PORTFOLIO_URL); ?>/" target="_blank" rel="noopener" class="text-brand-black underline decoration-brand-gray-300 hover:decoration-brand-gold">ibrahim.zibrahcode.com</a></dd>
    </div>
</dl>
<?php
$factsHtml = ob_get_clean();

require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-28 lg:pt-36 pb-20 lg:pb-32">
    <nav aria-label="Breadcrumb" class="text-xs text-brand-gray-500 mb-10 lg:mb-14">
        <a href="/index.php" class="hover:text-brand-black transition-colors">Home</a>
        <span class="mx-2" aria-hidden="true">/</span>
        <span class="text-brand-black">The Author</span>
    </nav>

    <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">

        <!-- Portrait + facts -->
        <aside class="lg:col-span-4 lg:sticky lg:top-28">
            <div class="aspect-[4/5] overflow-hidden max-w-[300px] sm:max-w-[360px] lg:max-w-none mx-auto">
                <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu, Author of Zibrah Code"
                    class="w-full h-full object-cover object-top" fetchpriority="high">
            </div>
            <div class="hidden lg:block mt-10"><?php echo $factsHtml; ?></div>
        </aside>

        <!-- Everything about the author, in reading order -->
        <article class="lg:col-span-8 max-w-3xl">
            <h1 class="text-4xl sm:text-5xl font-bold text-brand-black leading-tight">Ibrahim Ngugi Gatimu<span class="text-brand-gold">.</span></h1>
            <p class="text-sm text-brand-gray-500 mt-3">Author &middot; Finance Professional &middot; Social Entrepreneur</p>
            <p class="text-xl sm:text-2xl text-brand-gray-700 font-light leading-snug mt-6">
                Finance professional turned author and mentor, helping African leaders and entrepreneurs
                build careers and institutions rooted in unshakeable values.
            </p>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-4 mt-8">
                <a href="/inquire.php" class="btn-premium">Get in Touch</a>
                <a href="/book.php" class="text-sm font-semibold text-brand-black hover:text-brand-gold transition-colors">The book &rarr;</a>
            </div>

            <dl class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-14 pt-10 border-t border-brand-gray-200">
                <?php foreach ($stats as $stat): ?>
                    <div>
                        <dd class="text-3xl sm:text-4xl font-bold text-brand-black leading-none"><?php echo $stat['value']; ?></dd>
                        <dt class="text-sm text-brand-gray-500 mt-2 leading-snug"><?php echo $stat['label']; ?></dt>
                    </div>
                <?php endforeach; ?>
            </dl>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-5">Biography</h2>
                <div class="space-y-6 text-lg text-brand-gray-700 font-light leading-relaxed">
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
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">The journey</h2>
                <ol class="divide-y divide-brand-gray-100">
                    <?php foreach ($journey as $step): ?>
                        <li class="grid sm:grid-cols-[7rem_1fr] gap-x-4 gap-y-1 py-4 first:pt-0">
                            <span class="text-sm text-brand-gray-500 pt-0.5"><?php echo $step['when']; ?></span>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black"><?php echo $step['title']; ?></h3>
                                <p class="text-brand-gray-600 font-light leading-relaxed mt-0.5"><?php echo $step['body']; ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
                <a href="<?php echo e(PORTFOLIO_URL); ?>/journey.php" target="_blank" rel="noopener" class="inline-block mt-6 text-sm font-semibold text-brand-black hover:text-brand-gold transition-colors">Full journey &rarr;</a>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Organizations he has built</h2>
                <ul class="divide-y divide-brand-gray-100">
                    <?php foreach ($ventures as $venture): ?>
                        <li class="py-5 first:pt-0">
                            <p class="text-xs text-brand-gray-500 mb-1"><?php echo e($venture['kind']); ?></p>
                            <h3 class="text-lg font-semibold">
                                <a href="<?php echo e($venture['href']); ?>" <?php echo $venture['external'] ? 'target="_blank" rel="noopener"' : ''; ?> class="text-brand-black hover:text-brand-gold transition-colors"><?php echo e($venture['name']); ?> &rarr;</a>
                            </h3>
                            <p class="text-brand-gray-600 font-light leading-relaxed mt-1"><?php echo $venture['body']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Areas of engagement</h2>
                <ul class="grid sm:grid-cols-2 gap-x-10 gap-y-6">
                    <?php foreach ($engagements as $item): ?>
                        <li>
                            <h3 class="text-lg font-semibold text-brand-black"><?php echo $item['title']; ?></h3>
                            <p class="text-brand-gray-600 font-light leading-relaxed mt-1"><?php echo $item['body']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="/inquire.php" class="inline-block mt-8 text-sm font-semibold text-brand-black hover:text-brand-gold transition-colors">Book a time &rarr;</a>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Books</h2>
                <ul class="space-y-6">
                    <?php foreach ($books as $book): ?>
                        <li>
                            <a href="<?php echo e($book['href']); ?>" <?php echo $book['external'] ? 'target="_blank" rel="noopener"' : ''; ?> class="group flex gap-6 items-center">
                                <img src="<?php echo e($book['image']); ?>" alt="<?php echo e($book['title']); ?> cover" class="w-16 h-auto shadow-md flex-shrink-0" loading="lazy">
                                <div>
                                    <h3 class="text-lg font-semibold text-brand-black group-hover:text-brand-gold transition-colors"><?php echo e($book['title']); ?></h3>
                                    <p class="text-brand-gray-600 font-light leading-relaxed mt-0.5"><?php echo e($book['sub']); ?></p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <blockquote class="mt-12 pt-10 border-t border-brand-gray-200">
                <p class="text-xl sm:text-2xl text-brand-black font-light leading-snug">&ldquo;Structure is not the whole of wisdom. But without it, wisdom has nowhere to stand.&rdquo;</p>
                <cite class="not-italic text-sm text-brand-gray-500 block mt-3">Ibrahim Ngugi Gatimu</cite>
            </blockquote>

            <section class="lg:hidden mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">At a glance</h2>
                <?php echo $factsHtml; ?>
            </section>
        </article>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
