<?php
/**
 * The three angle-state cards (Open / Hardening / Closed). Include inside a
 * grid-ready container; data comes from angleStates() in functions.php.
 */
?>
<div class="grid md:grid-cols-3 gap-8">
    <?php foreach (angleStates() as $i => $state): ?>
        <div class="card bg-brand-gray-50 p-8 md:p-10">
            <div class="flex items-start justify-between mb-6">
                <?php echo angleGlyph($state['degrees']); ?>
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gray-400"><?php echo sprintf('%02d', $i + 1); ?></span>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-gold mb-2"><?php echo e($state['sub']); ?></p>
            <h3 class="serif text-3xl font-bold text-brand-black mb-4"><?php echo e($state['name']); ?></h3>
            <p class="text-brand-gray-600 font-light leading-relaxed"><?php echo $state['body']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
