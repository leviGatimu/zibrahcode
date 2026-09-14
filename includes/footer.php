    <!-- FOOTER -->
    <footer class="pt-32 pb-16 bg-brand-black text-white relative overflow-hidden border-t border-white/5">
        <div class="absolute -bottom-64 -right-64 w-[800px] h-[800px] border border-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-96 -right-96 w-[800px] h-[800px] border border-white/5 rounded-full pointer-events-none opacity-50"></div>
        <div class="section-container relative z-10">
            <div class="grid lg:grid-cols-12 gap-16 mb-24">
                <div class="lg:col-span-4">
                    <div class="text-3xl font-display font-black tracking-[0.3em] text-white uppercase mb-8">
                        ZIBRAH CODE<span class="text-brand-gold">™</span>
                    </div>
                    <p class="text-white/50 text-lg serif italic font-light leading-relaxed max-w-lg mb-10">
                        "Strategic Intelligence and Epistemic Alignment Systems. Modeling the geometry of human disagreement and the architecture of wisdom."
                    </p>
                    <form action="/actions/newsletter-subscribe" method="POST" class="flex max-w-sm mb-10">
                        <?php echo csrfField(); ?>
                        <?php echo spamGuardFields(); ?>
                        <input type="email" name="email" required placeholder="Your email"
                            class="flex-1 bg-white/5 border border-white/10 px-5 py-4 text-sm text-white placeholder-white/30 focus:outline-none focus:border-brand-gold transition-all">
                        <button type="submit" class="btn-gold text-[10px] px-6">Join</button>
                    </form>
                    <div class="flex items-center gap-5">
                        <a href="<?php echo e(YOUTUBE_URL); ?>" target="_blank" rel="noopener" aria-label="YouTube" class="text-white/40 hover:text-brand-gold transition-colors">
                            <svg class="w-6 h-6" viewBox="0 0 576 512" fill="currentColor"><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                        </a>
                        <a href="<?php echo e(X_URL); ?>" target="_blank" rel="noopener" aria-label="X (Twitter)" class="text-white/40 hover:text-brand-gold transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-3 lg:col-start-6">
                    <h5 class="text-brand-gold font-bold text-xs uppercase tracking-[0.4em] mb-10">Explore</h5>
                    <ul class="space-y-5">
                        <li><a href="/book.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">The Book</a></li>
                        <li><a href="/about.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">The Author</a></li>
                        <li><a href="/framework.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Framework</a></li>
                        <li><a href="/blog.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/podcast.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Podcast</a></li>
                    </ul>
                </div>
                <div class="lg:col-span-3">
                    <h5 class="text-brand-gold font-bold text-xs uppercase tracking-[0.4em] mb-10">Company</h5>
                    <ul class="space-y-5">
                        <li><a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="text-lg font-light text-white/40 hover:text-white transition-colors">Amazon Store</a></li>
                        <li><a href="/contact.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="/login.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="/admin/login.php" class="text-lg font-light text-white/40 hover:text-white transition-colors">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/20">
                    &copy; <?php echo date('Y'); ?> Zibrah Research Collective. All rights reserved.
                </div>
                <div class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-gold/60 italic">
                    Angles show what words cannot tell
                </div>
                <div class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/20">
                    Ibrahim Ngugi Gatimu
                </div>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js?v=<?php echo ASSETS_VERSION; ?>"></script>
</body>
</html>
