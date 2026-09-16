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
    ['title' => 'Leaders and decision-makers', 'body' => 'See why decisions harden under pressure and how to keep a team&rsquo;s options open long enough for correction to matter.'],
    ['title' => 'Mediators and facilitators', 'body' => 'A structural, side-neutral way to read a conflict before anyone has to be declared right. The geometry is visible first.'],
    ['title' => 'Reflective thinkers', 'body' => 'Turn the same tool on yourself: observe your own angle before you react, and notice when a belief has stopped rotating.'],
];

require __DIR__ . '/includes/header.php';
?>

<!-- PAGE HEADER: the book itself -->
<header class="bg-brand-gray-50 border-b border-brand-gray-100 overflow-hidden">
    <div class="section-container pt-24 lg:pt-40 pb-16 lg:pb-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7 reveal active">
                <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Book</p>
                <h1 class="text-5xl sm:text-6xl xl:text-7xl serif text-brand-black leading-none tracking-tighter font-black">The geometry of truth and wisdom.</h1>
                <p class="text-sm text-brand-gray-500 mt-6">Zibrah Code&trade; &middot; by <a href="/about.php" class="text-brand-black font-semibold hover:text-brand-gold transition-colors">Ibrahim Ngugi Gatimu</a></p>
                <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed mt-8 max-w-xl">
                    A new way to understand conflict, belief and leadership. Not through ideology, not through
                    psychology alone. Through geometry.
                </p>
                <div class="flex flex-wrap items-center gap-6 mt-10">
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
                    <a href="/framework.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Explore the Framework &rarr;</a>
                </div>
            </div>
            <figure class="lg:col-span-5 reveal active">
                <div class="bg-white border border-brand-gray-200 p-4 sm:p-6 shadow-2xl max-w-[320px] sm:max-w-[380px] lg:max-w-none mx-auto">
                    <img src="/assets/images/Front page.png" alt="Zibrah Code front cover" class="w-full h-auto" fetchpriority="high">
                </div>
                <figcaption class="text-[10px] uppercase tracking-[0.3em] text-brand-gray-500 mt-4 text-center">Kindle &middot; Print &middot; Available on Amazon</figcaption>
            </figure>
        </div>
    </div>
</header>

<!-- WHAT THE BOOK ARGUES -->
<section class="py-16 md:py-32 bg-white">
    <div class="section-container">
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Argument</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Belief lives in the angle, not in the argument.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">Truth and perception are held apart as two independent lines. What happens between them decides whether a conflict opens or closes.</p>
            </div>
            <div class="lg:col-span-3 space-y-8 text-lg sm:text-xl text-brand-gray-700 font-light leading-relaxed reveal active">
                <p>
                    The Zibrah Code introduces a geometric way of seeing how belief, judgment, and perception
                    interact under pressure. By mapping movement between truth and perception, the model reveals
                    why leadership decisions harden, why conflict escalates, and how stability can be restored
                    before breakdown occurs.
                </p>
                <p>
                    Rather than treating truth and perception as a single sliding scale, the Zibrah Code holds them
                    apart as independent dimensions. What happens between them, the angle, is where belief
                    actually lives, and it is that angle, not the argument, that determines whether a conflict
                    opens or closes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- INSIDE THE BOOK: THE FIVE AXIOMS -->
<section class="py-16 md:py-32 bg-brand-black text-white overflow-hidden relative">
    <div class="section-container relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32 reveal active">
                    <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Inside the Book</h4>
                    <h2 class="text-4xl sm:text-5xl serif font-black tracking-tight leading-tight mb-6">Five axioms. One geometry.</h2>
                    <p class="text-white/60 font-light leading-relaxed mb-10">The book builds its model from five structural statements, each one a move that most arguments skip.</p>
                    <a href="/framework.php" class="btn-invert">Read the Framework</a>
                </div>
            </div>
            <ol class="lg:col-span-8 divide-y divide-white/10">
                <?php foreach ($axioms as $axiom): ?>
                    <li class="py-8 first:pt-0 last:pb-0 reveal active">
                        <div class="grid grid-cols-[3rem_1fr] sm:grid-cols-[5rem_1fr] gap-4 sm:gap-8">
                            <span class="font-display font-black text-3xl sm:text-5xl text-brand-gold leading-none"><?php echo e($axiom['number']); ?></span>
                            <div>
                                <h3 class="serif text-2xl md:text-3xl font-bold text-white tracking-tight mb-3"><?php echo e($axiom['title']); ?></h3>
                                <p class="text-lg text-white/60 font-light leading-relaxed"><?php echo e(axiomLead($axiom['body'])); ?></p>
                            </div>
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
        <div class="grid lg:grid-cols-5 gap-16">
            <div class="lg:col-span-2 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Who It&rsquo;s For</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Written for the moment before a decision hardens.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md">The same tool reads a boardroom, a negotiation, or your own reaction to being contradicted.</p>
            </div>
            <div class="lg:col-span-3 grid sm:grid-cols-3 gap-x-10 gap-y-10 reveal active">
                <?php foreach ($audiences as $i => $audience): ?>
                    <div class="axiom-item">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-3"><?php echo sprintf('%02d', $i + 1); ?></p>
                        <h3 class="serif text-2xl font-bold text-brand-black mb-3"><?php echo $audience['title']; ?></h3>
                        <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $audience['body']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- THE AUTHOR -->
<section class="py-16 md:py-32 bg-brand-gray-50">
    <div class="section-container">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-4 reveal active">
                <div class="aspect-[4/5] overflow-hidden max-w-[300px] lg:max-w-none mx-auto lg:mx-0 shadow-2xl">
                    <img src="/assets/images/auther.jpeg?v=<?php echo ASSETS_VERSION; ?>" alt="Ibrahim Ngugi Gatimu" class="w-full h-full object-cover object-top" loading="lazy">
                </div>
            </div>
            <div class="lg:col-span-8 reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">The Author</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Ibrahim Ngugi Gatimu.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-2xl mb-6">
                    Finance professional, author and social entrepreneur with two decades of leadership across East
                    and Central Africa. Those years were spent inside organizations auditing complex systems, watching
                    how belief actually moves under pressure. The Zibrah Code is the residue of that observation.
                </p>
                <div class="flex flex-wrap items-center gap-6 mb-12">
                    <a href="/about.php" class="btn-premium">Meet the Author</a>
                    <a href="/inquire.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Book a Time &rarr;</a>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 mb-4">Also by the author</p>
                <a href="https://www.amazon.com/13TH-PROFESSIONAL-MINDSETS-Professional-Organizational-ebook/dp/B0D2WQCMHJ/" target="_blank" rel="noopener"
                   class="group inline-flex gap-6 items-center bg-white border border-brand-gray-200 p-5 pr-8 hover:border-brand-black transition-colors">
                    <img src="/assets/images/profesional.jpg" alt="The 13th Professional cover" class="w-14 h-auto shadow-md flex-shrink-0" loading="lazy">
                    <div>
                        <p class="serif text-xl font-bold text-brand-black group-hover:text-brand-gold transition-colors">The 13th Professional</p>
                        <p class="text-sm text-brand-gray-600 font-light">A blueprint for values-based professional excellence.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- BUY -->
<section class="py-16 md:py-32 bg-white border-t border-brand-gray-100">
    <div class="section-container">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal active">
                <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Get the Book</h4>
                <h2 class="text-4xl sm:text-5xl serif text-brand-black font-black tracking-tight leading-tight mb-6">Available now in print and on Kindle.</h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed max-w-md mb-10">Zibrah Code&trade;: The Geometry of Truth and Wisdom Model in Leadership, Judgment, and Conflict. English edition, sold through Amazon.</p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-premium">Buy on Amazon</a>
                    <a href="/blog.php" class="text-xs font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Read the Blog &rarr;</a>
                </div>
            </div>
            <dl class="bg-brand-gray-50 border border-brand-gray-200 divide-y divide-brand-gray-100 reveal active">
                <?php foreach ([['Formats', 'Kindle &middot; Print'], ['Language', 'English'], ['Subjects', 'Leadership &middot; Philosophy &middot; Conflict Resolution'], ['Author', 'Ibrahim Ngugi Gatimu']] as [$label, $value]): ?>
                    <div class="grid grid-cols-[7rem_1fr] sm:grid-cols-[9rem_1fr] gap-4 px-6 py-4">
                        <dt class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-500 pt-1"><?php echo $label; ?></dt>
                        <dd class="text-brand-black"><?php echo $value; ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
