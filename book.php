<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'The Book | Zibrah Code™: The Geometry of Truth and Wisdom';
$pageDescription = 'Zibrah Code: The Geometry of Truth and Wisdom by Ibrahim Ngugi is a geometric model separating truth and perception to reveal how belief and conflict evolve.';
$canonicalPath = '/book.php';
$activeNav = 'book';
$ogImage = SITE_URL . '/assets/images/Front page.png';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"Book","name":"Zibrah Code: The Geometry of Truth and Wisdom","alternateName":"ZibrahCode","author":{"@type":"Person","name":"Ibrahim Ngugi"},"url":"' . SITE_URL . '/book.php","image":"' . SITE_URL . '/assets/images/Front page.png","description":' . json_encode($pageDescription) . ',"inLanguage":"en","genre":["Leadership","Philosophy","Strategic Thinking","Conflict Resolution"],"offers":{"@type":"Offer","availability":"https://schema.org/InStock","url":"' . AMAZON_URL . '","seller":{"@type":"Organization","name":"Amazon"}}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"The Book","item":"' . SITE_URL . '/book.php"}]}',
];

$axioms = require __DIR__ . '/includes/axioms.php';

// Lead sentence(s) of an axiom for the summary list — whole sentences only,
// enough of them to pass ~90 characters, so nothing is cut mid-thought.
function axiomLead(string $body, int $minLength = 90): string
{
    $sentences = preg_split('/(?<=[.!?])\s+/u', trim($body));
    $lead = '';
    foreach ($sentences as $sentence) {
        $lead .= ($lead === '' ? '' : ' ') . $sentence;
        if (mb_strlen($lead) >= $minLength) {
            break;
        }
    }
    return $lead;
}

$audiences = [
    ['title' => 'Leaders and decision-makers', 'body' => 'Why decisions harden under pressure, and how to keep a team&rsquo;s options open long enough for correction to matter.'],
    ['title' => 'Mediators and facilitators', 'body' => 'A side-neutral way to read a conflict before anyone has to be declared right.'],
    ['title' => 'Reflective thinkers', 'body' => 'Turn the same tool on yourself: notice when a belief has stopped rotating.'],
];

$details = [
    ['label' => 'Formats', 'value' => 'Kindle &middot; Print'],
    ['label' => 'Language', 'value' => 'English'],
    ['label' => 'Subjects', 'value' => 'Leadership &middot; Philosophy &middot; Conflict Resolution'],
    ['label' => 'Available at', 'value' => '<a href="' . e(AMAZON_URL) . '" target="_blank" rel="noopener" class="underline decoration-brand-gray-300 hover:decoration-brand-gold">Amazon</a>'],
];

// Details + "also by" are rendered once and placed twice: under the cover on
// desktop, after the author on phones (so the title follows the cover there).
ob_start();
?>
<dl class="border-t border-brand-gray-200">
    <?php foreach ($details as $row): ?>
        <div class="grid grid-cols-[7rem_1fr] gap-4 py-3 border-b border-brand-gray-100 text-sm">
            <dt class="text-brand-gray-500"><?php echo e($row['label']); ?></dt>
            <dd class="text-brand-black"><?php echo $row['value']; ?></dd>
        </div>
    <?php endforeach; ?>
</dl>
<a href="https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/" target="_blank" rel="noopener"
   class="group mt-8 flex gap-5 items-center">
    <img src="/assets/images/profesional.jpg" alt="The 13th Professional cover" class="w-12 h-auto shadow-md flex-shrink-0" loading="lazy">
    <div class="text-sm">
        <p class="text-brand-gray-500 text-xs mb-0.5">Also by the author</p>
        <p class="font-semibold text-brand-black group-hover:text-brand-gold transition-colors">The 13th Professional</p>
    </div>
</a>
<?php
$factsHtml = ob_get_clean();

require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-28 lg:pt-36 pb-20 lg:pb-32">
    <nav aria-label="Breadcrumb" class="text-xs text-brand-gray-500 mb-10 lg:mb-14">
        <a href="/index.php" class="hover:text-brand-black transition-colors">Home</a>
        <span class="mx-2" aria-hidden="true">/</span>
        <span class="text-brand-black">The Book</span>
    </nav>

    <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">

        <!-- Cover + facts -->
        <aside class="lg:col-span-5 lg:sticky lg:top-28">
            <img src="/assets/images/Front page.png" alt="Zibrah Code front cover"
                class="w-full max-w-[300px] sm:max-w-[360px] lg:max-w-none mx-auto shadow-[0_30px_60px_-20px_rgba(0,0,0,0.35)]" fetchpriority="high">

            <div class="hidden lg:block mt-10"><?php echo $factsHtml; ?></div>
        </aside>

        <!-- Everything about the book, in reading order -->
        <article class="lg:col-span-7 max-w-2xl">
            <h1 class="text-4xl sm:text-5xl font-bold text-brand-black leading-tight">Zibrah Code<span class="text-brand-gold">.</span></h1>
            <p class="text-xl sm:text-2xl text-brand-gray-700 font-light leading-snug mt-4">The Geometry of Truth and Wisdom Model in Leadership, Judgment, and Conflict</p>
            <p class="text-sm text-brand-gray-500 mt-4">By <a href="/about.php" class="text-brand-black font-semibold hover:text-brand-gold transition-colors">Ibrahim Ngugi Gatimu</a></p>

            <div class="flex flex-wrap items-center gap-x-6 gap-y-4 mt-8">
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
                <span class="text-sm text-brand-gray-500">Kindle and print</span>
            </div>

            <section class="mt-14 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-5">About the book</h2>
                <p class="text-lg text-brand-gray-700 font-light leading-relaxed">
                    The Zibrah Code is a geometric way of seeing how belief, judgment and perception interact under
                    pressure. Instead of treating truth and perception as one sliding scale, it holds them apart as
                    independent lines. The angle between them is where belief lives, and it is that angle, not the
                    argument, that decides whether a conflict opens or closes. The model shows why leadership
                    decisions harden, why conflict escalates, and how stability can be restored before breakdown.
                </p>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Inside the book</h2>
                <ol class="divide-y divide-brand-gray-100">
                    <?php foreach ($axioms as $axiom): ?>
                        <li class="grid grid-cols-[2.5rem_1fr] gap-4 py-5 first:pt-0">
                            <span class="text-sm font-bold text-brand-gold pt-1"><?php echo e($axiom['number']); ?></span>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black"><?php echo e($axiom['title']); ?></h3>
                                <p class="text-brand-gray-600 font-light leading-relaxed mt-1"><?php echo e(axiomLead($axiom['body'])); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
                <a href="/framework.php" class="inline-block mt-6 text-sm font-semibold text-brand-black hover:text-brand-gold transition-colors">Read the full framework &rarr;</a>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Who it&rsquo;s for</h2>
                <ul class="space-y-5">
                    <?php foreach ($audiences as $audience): ?>
                        <li>
                            <h3 class="text-lg font-semibold text-brand-black"><?php echo $audience['title']; ?></h3>
                            <p class="text-brand-gray-600 font-light leading-relaxed mt-1"><?php echo $audience['body']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">About the author</h2>
                <div class="flex gap-6 items-start">
                    <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu" class="w-20 h-20 object-cover object-top flex-shrink-0" loading="lazy">
                    <div>
                        <p class="text-lg font-semibold text-brand-black">Ibrahim Ngugi Gatimu</p>
                        <p class="text-brand-gray-600 font-light leading-relaxed mt-1">Finance professional, author and social entrepreneur. Two decades auditing complex systems across East and Central Africa, watching how belief actually moves under pressure.</p>
                        <a href="/about.php" class="inline-block mt-3 text-sm font-semibold text-brand-black hover:text-brand-gold transition-colors">Meet the author &rarr;</a>
                    </div>
                </div>
            </section>

            <section class="lg:hidden mt-12 pt-10 border-t border-brand-gray-200">
                <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Details</h2>
                <?php echo $factsHtml; ?>
            </section>
        </article>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
