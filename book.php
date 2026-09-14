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
    ['title' => 'Leaders &amp; decision-makers', 'body' => 'See why decisions harden under pressure and how to keep a team&rsquo;s options open long enough for correction to matter.'],
    ['title' => 'Mediators &amp; facilitators', 'body' => 'A structural, side-neutral way to read a conflict before anyone has to be declared right &mdash; the geometry is visible first.'],
    ['title' => 'Reflective thinkers', 'body' => 'Turn the same tool on yourself: observe your own angle before you react, and notice when a belief has stopped rotating.'],
];

$details = [
    ['label' => 'Title', 'value' => 'Zibrah Code&trade;: The Geometry of Truth and Wisdom Model in Leadership, Judgment, and Conflict'],
    ['label' => 'Author', 'value' => 'Ibrahim Ngugi Gatimu'],
    ['label' => 'Formats', 'value' => 'Kindle &middot; Print'],
    ['label' => 'Language', 'value' => 'English'],
    ['label' => 'Fields', 'value' => 'Leadership &middot; Philosophy &middot; Conflict Resolution'],
    ['label' => 'Available at', 'value' => 'Amazon'],
];

require __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<header class="bg-brand-gray-50 border-b border-brand-gray-100 overflow-hidden">
    <div class="section-container pt-24 lg:pt-40 pb-16 lg:pb-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            <!-- Cover: shown whole, never cropped -->
            <div class="lg:col-span-5 lg:order-2 reveal active">
                <div class="relative max-w-[280px] sm:max-w-[340px] lg:max-w-[400px] mx-auto">
                    <div class="absolute -inset-6 border border-brand-gold/20 pointer-events-none" aria-hidden="true"></div>
                    <img src="/assets/images/Back page.png" alt="" aria-hidden="true"
                        class="absolute top-6 -right-10 w-3/4 h-auto opacity-40 shadow-xl hidden sm:block" loading="lazy">
                    <img src="/assets/images/Front page.png" alt="Zibrah Code — front cover"
                        class="relative w-full h-auto shadow-[0_40px_80px_-20px_rgba(0,0,0,0.45)]" fetchpriority="high">
                </div>
            </div>

            <div class="lg:col-span-7 lg:order-1 text-center lg:text-left reveal active">
                <p class="text-brand-gold font-bold text-xs tracking-[0.5em] uppercase mb-6">The Book</p>
                <h1 class="text-5xl sm:text-6xl xl:text-8xl font-display font-black text-brand-black uppercase tracking-tighter leading-[0.9]">The Zibrah<br>Code<span class="text-brand-gold">.</span></h1>
                <p class="text-xl sm:text-2xl serif italic text-brand-gray-700 mt-6 max-w-xl mx-auto lg:mx-0">The Geometry of Truth and Wisdom Model in Leadership, Judgment, and Conflict.</p>
                <p class="text-xs uppercase tracking-[0.3em] text-brand-gray-500 mt-4">By Ibrahim Ngugi Gatimu</p>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mt-8 max-w-xl mx-auto lg:mx-0">
                    A new way to understand conflict, belief and leadership. Not through ideology, not through
                    psychology alone. Through geometry.
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start items-center gap-6 mt-10">
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
                    <a href="/framework.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Explore the Framework &rarr;</a>
                </div>
                <ul class="flex flex-wrap justify-center lg:justify-start gap-2 mt-10" aria-label="Formats">
                    <?php foreach (['Kindle', 'Print', '5 Axioms'] as $chip): ?>
                        <li class="text-[10px] font-bold uppercase tracking-widest text-brand-black bg-white border border-brand-gray-200 px-3 py-2"><?php echo e($chip); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- WHAT THE BOOK ARGUES -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Argument</h4>
                <p class="text-3xl md:text-4xl serif italic text-brand-black leading-snug border-l-4 border-brand-gold pl-8">
                    Angles show what words cannot tell.
                </p>
            </div>
            <div class="lg:col-span-3 reveal active">
                <p class="drop-cap text-xl sm:text-2xl text-brand-gray-700 font-light leading-relaxed mb-8">
                    The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                    interact under pressure. By mapping movement between truth and perception, the model reveals
                    why leadership decisions harden, why conflict escalates, and how stability can be restored
                    before breakdown occurs.
                </p>
                <p class="text-xl sm:text-2xl text-brand-gray-700 font-light leading-relaxed">
                    Rather than treating truth and perception as a single sliding scale, the Zibrah Code holds them
                    apart as independent dimensions. What happens between them &mdash; the angle &mdash; is where belief
                    actually lives, and it is that angle, not the argument, that determines whether a conflict
                    opens or closes.
                </p>
                <div class="mt-10 pt-8 border-t border-brand-gray-100">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 mb-4">Reading the angle</p>
                    <?php echo angleScale(); ?>
                    <a href="/framework.php" class="inline-block mt-5 text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">How the model works &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INSIDE THE BOOK: THE FIVE AXIOMS -->
<section class="py-16 md:py-32 bg-brand-black text-white overflow-hidden relative">
    <div class="absolute -top-24 -right-24 w-[500px] h-[500px] border border-white/5 rounded-full pointer-events-none" aria-hidden="true"></div>
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Inside the Book</h4>
                <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Five axioms. One geometry.</h2>
                <p class="text-lg text-white/60 font-light leading-relaxed max-w-md mb-10">The book builds its model from five structural statements, each one a move that most arguments skip.</p>
                <a href="/framework.php" class="btn-invert">Read the Framework</a>
            </div>
            <ol class="lg:col-span-3 divide-y divide-white/10 reveal active">
                <?php foreach ($axioms as $axiom): ?>
                    <li class="grid grid-cols-[3rem_1fr] gap-6 py-8 first:pt-0 last:pb-0">
                        <span class="font-display font-black text-3xl text-brand-gold leading-none"><?php echo e($axiom['number']); ?></span>
                        <div>
                            <h3 class="serif text-2xl sm:text-3xl font-bold text-white mb-3"><?php echo e($axiom['title']); ?></h3>
                            <p class="text-white/60 font-light leading-relaxed"><?php echo e(axiomLead($axiom['body'])); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- WHO IT'S FOR -->
<section class="py-16 md:py-32 bg-white border-b border-brand-gray-100">
    <div class="section-container">
        <div class="max-w-2xl mb-10 md:mb-16 reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Who It&rsquo;s For</h4>
            <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight">Written for the moment before a decision hardens.</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($audiences as $i => $audience): ?>
                <div class="card bg-brand-gray-50 p-10 reveal active">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-6"><?php echo sprintf('%02d', $i + 1); ?></p>
                    <h3 class="serif text-2xl font-bold text-brand-black mb-4"><?php echo $audience['title']; ?></h3>
                    <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $audience['body']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- DETAILS + AUTHOR -->
<section class="py-16 md:py-32 bg-brand-gray-50">
    <div class="section-container grid lg:grid-cols-2 gap-16 items-start">
        <div class="reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Details</h4>
            <dl class="bg-white border border-brand-gray-200 divide-y divide-brand-gray-100">
                <?php foreach ($details as $row): ?>
                    <div class="grid grid-cols-[7rem_1fr] sm:grid-cols-[9rem_1fr] gap-4 px-6 py-4">
                        <dt class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 pt-1"><?php echo e($row['label']); ?></dt>
                        <dd class="serif text-lg text-brand-black"><?php echo $row['value']; ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
        <div class="reveal active">
            <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Author</h4>
            <a href="/about.php" class="group flex gap-6 sm:gap-8 items-start bg-white border border-brand-gray-200 p-6 sm:p-8 hover:border-brand-black transition-colors">
                <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu" class="w-24 h-24 sm:w-32 sm:h-32 object-cover object-top flex-shrink-0" loading="lazy">
                <div>
                    <p class="serif text-2xl font-bold text-brand-black group-hover:text-brand-gold transition-colors">Ibrahim Ngugi Gatimu</p>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 mt-1 mb-4">Author &middot; Finance Professional &middot; Social Entrepreneur</p>
                    <p class="text-brand-gray-600 font-light leading-relaxed">Two decades auditing complex systems across East and Central Africa &mdash; watching how belief actually moves under pressure. The Zibrah Code is the residue of that observation.</p>
                    <span class="inline-block mt-5 text-xs font-bold uppercase tracking-widest text-brand-black group-hover:text-brand-gold transition-colors">Meet the author &rarr;</span>
                </div>
            </a>

            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 mt-10 mb-4">Also by the author</p>
            <a href="https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/" target="_blank" rel="noopener"
               class="group flex gap-6 items-center bg-white border border-brand-gray-200 p-5 hover:border-brand-black transition-colors">
                <img src="/assets/images/profesional.jpg" alt="The 13th Professional — cover" class="w-16 h-auto shadow-md flex-shrink-0" loading="lazy">
                <div>
                    <p class="serif text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors">The 13th Professional</p>
                    <p class="text-sm text-brand-gray-600 font-light">A blueprint for values-based professional excellence.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- BUY CTA -->
<section class="py-16 md:py-32 bg-white text-center">
    <div class="section-container reveal active">
        <img src="/assets/images/Front page.png" alt="" aria-hidden="true" class="w-28 h-auto mx-auto shadow-xl mb-10" loading="lazy">
        <h3 class="text-4xl sm:text-5xl md:text-6xl serif mb-6 leading-none font-black tracking-tighter text-brand-black">Get your copy.</h3>
        <p class="text-lg sm:text-xl text-brand-gray-600 mb-10 font-light leading-relaxed max-w-xl mx-auto italic">Available in print and digital formats via Amazon. A foundational text for leaders, thinkers, and strategists.</p>
        <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
