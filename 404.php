<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/includes/bootstrap.php';
}
$pageTitle = 'Page Not Found | Zibrah Code™';
$pageDescription = 'The page you are looking for could not be found.';
$canonicalPath = '/404.php';
$activeNav = '';
$robotsMeta = 'noindex, follow';
require __DIR__ . '/includes/header.php';
?>
<main class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-white text-center px-6 pt-24 md:pt-32 pb-16 md:pb-24">

    <!-- Ambient geometric construction, drawn in behind the content -->
    <svg class="absolute w-[640px] h-[640px] max-w-[90vw] max-h-[90vw] pointer-events-none" viewBox="0 0 600 600" aria-hidden="true">
        <circle cx="300" cy="300" r="220" fill="none" stroke="#E5E5E5" stroke-width="1" class="geo-draw" style="stroke-dasharray:1400; animation-delay:.1s" />
        <line x1="60" y1="300" x2="540" y2="300" stroke="#E5E5E5" stroke-width="1" class="geo-draw" style="stroke-dasharray:480; animation-delay:.3s" />
        <line x1="300" y1="60" x2="300" y2="540" stroke="#E5E5E5" stroke-width="1" class="geo-draw" style="stroke-dasharray:480; animation-delay:.4s" />
        <line x1="130" y1="130" x2="470" y2="470" stroke="#B89441" stroke-width="1" opacity="0.3" class="geo-draw" style="stroke-dasharray:480; animation-delay:.6s" />
        <line x1="470" y1="130" x2="130" y2="470" stroke="#B89441" stroke-width="1" opacity="0.3" class="geo-draw" style="stroke-dasharray:480; animation-delay:.7s" />
        <g class="geo-hand">
            <line x1="300" y1="300" x2="300" y2="110" stroke="#B89441" stroke-width="1.5" />
        </g>
        <circle cx="300" cy="300" r="3.5" fill="#B89441" />
    </svg>

    <div class="relative z-10">
        <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6 reveal active">Lost Coordinates</p>

        <svg viewBox="0 0 640 200" class="w-full max-w-xl sm:max-w-2xl mx-auto mb-4" aria-label="404" role="img">
            <text x="50%" y="72%" text-anchor="middle" class="draw-404">404</text>
        </svg>

        <h1 class="text-3xl sm:text-4xl md:text-5xl serif text-brand-black font-black tracking-tighter mb-6">This angle doesn't resolve.</h1>
        <p class="text-lg sm:text-xl text-brand-gray-600 font-light max-w-xl mx-auto mb-12">The page you're looking for doesn't exist, or the line between truth and perception led somewhere else.</p>
        <a href="/index.php" class="btn-premium">Back to Home</a>
    </div>
</main>

<style>
.draw-404 {
    font-family: 'Playfair Display', serif;
    font-size: 150px;
    font-weight: 900;
    fill: none;
    stroke: #B89441;
    stroke-width: 1.5;
    stroke-dasharray: 6000;
    stroke-dashoffset: 6000;
    animation: draw-404-stroke 2.2s cubic-bezier(.65,0,.35,1) forwards,
               draw-404-fill 0.7s ease forwards;
    animation-delay: 0.2s, 2s;
}
@keyframes draw-404-stroke { to { stroke-dashoffset: 0; } }
@keyframes draw-404-fill { to { fill: #1A1A1A; } }

.geo-draw {
    stroke-dashoffset: 1400;
    animation: geo-draw 1.6s ease forwards;
}
@keyframes geo-draw { to { stroke-dashoffset: 0; } }

.geo-hand {
    transform-origin: 300px 300px;
    animation: geo-spin 14s linear infinite;
    animation-delay: 1.8s;
}
@keyframes geo-spin { to { transform: rotate(360deg); } }

@media (prefers-reduced-motion: reduce) {
    .draw-404, .geo-draw, .geo-hand {
        animation: none !important;
    }
    .draw-404 { fill: #1A1A1A; stroke-dashoffset: 0; }
    .geo-draw { stroke-dashoffset: 0; }
}
</style>

<?php require __DIR__ . '/includes/footer.php'; ?>
