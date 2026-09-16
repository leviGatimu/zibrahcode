<?php
/**
 * The three angle-state cards (Open / Hardening / Closed). Include inside a
 * grid-ready container; data comes from angleStates() in functions.php.
 */
?>
<div class="grid md:grid-cols-3 gap-4 md:gap-8">
    <?php foreach (angleStates() as $i => $state): ?>
        <div class="card bg-brand-gray-50 p-6 md:p-10 flex gap-5 md:block">
            <div class="flex-shrink-0 md:flex md:items-start md:justify-between md:mb-6">
                <?php echo angleGlyph($state['degrees'], 'w-16 h-16 md:w-24 md:h-24'); ?>
                <span class="hidden md:inline text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-400"><?php echo sprintf('%02d', $i + 1); ?></span>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-1 md:mb-2"><?php echo e($state['sub']); ?></p>
                <h3 class="serif text-2xl md:text-3xl font-bold text-brand-black mb-2 md:mb-4"><?php echo e($state['name']); ?></h3>
                <p class="text-sm md:text-base text-brand-gray-600 font-light leading-relaxed"><?php echo $state['body']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
