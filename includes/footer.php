    <!-- FOOTER -->
    <footer class="bg-brand-black text-white pt-16 md:pt-24 pb-10 border-t border-brand-gold/40">
        <div class="section-container">
            <div class="grid grid-cols-2 lg:grid-cols-12 gap-y-14 gap-x-8 lg:gap-x-16 pb-14 md:pb-20">

                <!-- Brand -->
                <div class="col-span-2 lg:col-span-5">
                    <a href="/index.php" class="inline-flex items-baseline text-xl font-bold tracking-[0.3em] uppercase text-white">
                        ZIBRAH CODE<span class="text-brand-gold text-xs ml-1">™</span>
                    </a>
                    <blockquote class="mt-8 pl-5 border-l-2 border-brand-gold max-w-md">
                        <p class="serif italic text-lg md:text-xl leading-relaxed text-white/80">
                            Strategic Intelligence and Epistemic Alignment Systems. Modeling the geometry of human disagreement and the architecture of wisdom.
                        </p>
                    </blockquote>

                    <div class="mt-10 max-w-md">
                        <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-white/60 mb-4">Newsletter</p>
                        <form action="/actions/newsletter-subscribe" method="POST" class="flex">
                            <?php echo csrfField(); ?>
                            <?php echo spamGuardFields(); ?>
                            <input type="hidden" name="source" value="footer">
                            <label for="footer-email" class="sr-only">Email address</label>
                            <input id="footer-email" type="email" name="email" required autocomplete="email" placeholder="Your email address"
                                class="flex-1 min-w-0 h-12 bg-white/[0.06] border border-white/15 border-r-0 px-4 text-sm text-white placeholder-white/40 focus:outline-none focus:border-brand-gold focus:bg-white/10 transition-colors">
                            <button type="submit" class="h-12 px-6 bg-brand-gold text-brand-black text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-[#D4B876] transition-colors">Join</button>
                        </form>
                    </div>

                    <div class="mt-10 flex items-center gap-3">
                        <a href="<?php echo e(YOUTUBE_URL); ?>" target="_blank" rel="noopener" aria-label="YouTube"
                           class="w-10 h-10 inline-flex items-center justify-center border border-white/15 text-white/70 hover:border-brand-gold hover:text-brand-gold transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 576 512" fill="currentColor" aria-hidden="true"><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                        </a>
                        <a href="<?php echo e(X_URL); ?>" target="_blank" rel="noopener" aria-label="X (Twitter)"
                           class="w-10 h-10 inline-flex items-center justify-center border border-white/15 text-white/70 hover:border-brand-gold hover:text-brand-gold transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Explore -->
                <div class="lg:col-span-3 lg:col-start-7">
                    <h5 class="font-sans text-[11px] font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Explore</h5>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="/book.php" class="text-white/70 hover:text-white transition-colors">The Book</a></li>
                        <li><a href="/about.php" class="text-white/70 hover:text-white transition-colors">The Author</a></li>
                        <li><a href="/framework.php" class="text-white/70 hover:text-white transition-colors">Framework</a></li>
                        <li><a href="/blog.php" class="text-white/70 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/podcast.php" class="text-white/70 hover:text-white transition-colors">Podcast</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="lg:col-span-3">
                    <h5 class="font-sans text-[11px] font-bold uppercase tracking-[0.25em] text-brand-gold mb-6">Company</h5>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="text-white/70 hover:text-white transition-colors">Amazon Store</a></li>
                        <li><a href="/contact.php" class="text-white/70 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="/login.php" class="text-white/70 hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="/admin/login.php" class="text-white/70 hover:text-white transition-colors">Admin</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-xs text-white/50">
                <p>&copy; <?php echo date('Y'); ?> Zibrah Research Collective. All rights reserved.</p>
                <p class="serif italic text-sm text-brand-gold/80">Angles show what words cannot tell</p>
                <p class="uppercase tracking-[0.2em] text-[11px]">Ibrahim Ngugi Gatimu</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js?v=<?php echo ASSETS_VERSION; ?>"></script>
</body>
</html>
