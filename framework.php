<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'The Zibrah Code Framework | Axioms of Truth & Perception';
$pageDescription = 'The five axiomatic principles of the Zibrah Code — the structural logic behind how truth, perception, belief, and wisdom interact under pressure.';
$canonicalPath = '/framework.php';
$activeNav = 'framework';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"The Framework","item":"' . SITE_URL . '/framework.php"}]}',
];
require __DIR__ . '/includes/header.php';

$axioms = [
    [
        'number' => '01',
        'title' => 'Truth is a claim.',
        'body' => 'Truth, in the Zibrah Code, is not treated as a possession or a prize — it is a claim, made and held independently of whoever is making it. Separating truth from the person asserting it is the first structural move the model requires, because it is the move most arguments skip.',
    ],
    [
        'number' => '02',
        'title' => 'Perception is interpretation.',
        'body' => 'Perception is not truth arriving unfiltered — it is truth passed through interpretation. Two people can stand in front of the same claim and walk away with different angles, not because one of them is lying, but because interpretation is a separate axis entirely.',
    ],
    [
        'number' => '03',
        'title' => 'Belief emerges from their interaction.',
        'body' => 'Belief is not truth and it is not perception. It is what forms in the angle between them. This is why belief can feel absolutely solid to the person holding it while remaining, structurally, a byproduct of two independent, movable dimensions.',
    ],
    [
        'number' => '04',
        'title' => 'Extremes can be symmetrical.',
        'body' => 'Opposing positions that feel like polar opposites often share the same geometry — the same narrow angle, the same locked posture, just facing different directions. The model reveals that certainty on either side of a conflict can be structurally identical.',
    ],
    [
        'number' => '05',
        'title' => 'Wisdom is alignment, not projection.',
        'body' => 'Wisdom, in this framework, is not the ability to convince others of a position. It is the ongoing alignment between truth and perception — a discipline of keeping the angle open rather than forcing it toward a preferred conclusion.',
    ],
];
?>

<!-- HERO -->
<header class="section-container pt-40 pb-24 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none flex items-center justify-center">
        <div class="w-[900px] h-[900px] border border-brand-gold rounded-full animate-[spin_60s_linear_infinite]"></div>
    </div>
    <div class="relative z-10">
        <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10 reveal active">The Framework</p>
        <h1 class="text-5xl sm:text-6xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black italic reveal active">Key Statements.</h1>
        <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed max-w-2xl mx-auto mt-10 reveal active">A specialized collection of axiomatic principles that define the Zibrah Code model's structural logic — five moves, in order.</p>
    </div>
</header>

<!-- AXIOMS -->
<section class="bg-white overflow-hidden">
    <?php foreach ($axioms as $i => $axiom): ?>
        <div class="relative py-20 md:py-28 <?php echo $i % 2 === 0 ? 'bg-white' : 'bg-brand-gray-50'; ?> <?php echo $i > 0 ? 'border-t border-brand-gray-100' : ''; ?>">
            <div class="hidden lg:flex absolute inset-0 items-center pointer-events-none overflow-hidden <?php echo $i % 2 === 0 ? 'justify-end' : 'justify-start'; ?>">
                <span class="text-[20rem] font-display font-black text-brand-black/[0.03] leading-none select-none"><?php echo e($axiom['number']); ?></span>
            </div>
            <div class="section-container relative z-10">
                <div class="reveal active lg:max-w-3xl <?php echo $i % 2 === 0 ? '' : 'lg:ml-auto lg:text-right'; ?>" style="transition-delay: <?php echo min($i, 3) * 100; ?>ms;">
                    <div class="flex items-center gap-4 mb-6 <?php echo $i % 2 === 0 ? '' : 'lg:justify-end'; ?>">
                        <span class="w-10 h-10 flex items-center justify-center bg-brand-black text-brand-gold font-display font-black text-sm"><?php echo e($axiom['number']); ?></span>
                        <span class="h-px flex-1 max-w-[80px] bg-brand-gold/40"></span>
                    </div>
                    <h3 class="text-3xl md:text-5xl serif text-brand-black font-bold tracking-tight mb-6"><?php echo e($axiom['title']); ?></h3>
                    <p class="text-lg md:text-xl text-brand-gray-600 font-light leading-relaxed"><?php echo e($axiom['body']); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<!-- CLOSING QUOTE + CTA -->
<section class="py-32 bg-brand-black text-white text-center overflow-hidden">
    <div class="section-container reveal active max-w-3xl mx-auto">
        <p class="text-3xl md:text-4xl serif italic leading-snug mb-14">Angles show what words cannot tell.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-8">
            <a href="/book.php" class="btn-invert">Read More About the Book</a>
            <a href="/podcast.php" class="text-xs font-black uppercase tracking-[0.4em] border-b-2 border-white/30 pb-2 hover:text-brand-gold hover:border-brand-gold transition-all">Listen to the Podcast</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
