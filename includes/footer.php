    <!-- FOOTER -->
    <footer class="bg-brand-black text-white border-t border-white/10">
        <div class="section-container pt-16 md:pt-20 pb-8">

            <div class="grid grid-cols-2 lg:grid-cols-12 gap-x-8 gap-y-12 pb-14 md:pb-16 border-b border-white/10">

                <!-- Brand + newsletter -->
                <div class="col-span-2 lg:col-span-5 lg:pr-12">
                    <a href="/index.php" class="inline-block text-base font-bold tracking-[0.25em] uppercase text-white">ZIBRAH CODE<span class="text-brand-gold text-[10px] align-top ml-1">™</span></a>
                    <p class="mt-5 text-sm text-white/60 leading-relaxed max-w-sm">
                        Strategic Intelligence and Epistemic Alignment Systems. Modeling the geometry of human disagreement and the architecture of wisdom.
                    </p>
                    <form action="/actions/newsletter-subscribe" method="POST" class="mt-8 max-w-sm">
                        <?php echo csrfField(); ?>
                        <?php echo spamGuardFields(); ?>
                        <input type="hidden" name="source" value="footer">
                        <label for="footer-email" class="block text-xs font-semibold uppercase tracking-widest text-white mb-3">Newsletter</label>
                        <div class="flex">
                            <input id="footer-email" type="email" name="email" required autocomplete="email" placeholder="Email address"
                                class="flex-1 min-w-0 h-11 bg-transparent border border-white/20 px-4 text-sm text-white placeholder-white/40 focus:outline-none focus:border-white transition-colors">
                            <button type="submit" class="h-11 px-5 bg-white text-brand-black text-xs font-semibold uppercase tracking-widest hover:bg-brand-gold transition-colors">Join</button>
                        </div>
                    </form>
                </div>

                <!-- Explore -->
                <div class="lg:col-span-2 lg:col-start-7">
                    <h5 class="font-sans text-xs font-semibold uppercase tracking-widest text-white mb-5">Explore</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/book.php" class="text-white/60 hover:text-white transition-colors">The Book</a></li>
                        <li><a href="/about.php" class="text-white/60 hover:text-white transition-colors">The Author</a></li>
                        <li><a href="/framework.php" class="text-white/60 hover:text-white transition-colors">Framework</a></li>
                        <li><a href="/blog.php" class="text-white/60 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/podcast.php" class="text-white/60 hover:text-white transition-colors">Podcast</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="lg:col-span-2">
                    <h5 class="font-sans text-xs font-semibold uppercase tracking-widest text-white mb-5">Company</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="text-white/60 hover:text-white transition-colors">Amazon Store</a></li>
                        <li><a href="/contact.php" class="text-white/60 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="/login.php" class="text-white/60 hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="/admin/login.php" class="text-white/60 hover:text-white transition-colors">Admin</a></li>
                    </ul>
                </div>

                <!-- Follow -->
                <div class="col-span-2 sm:col-span-1 lg:col-span-2">
                    <h5 class="font-sans text-xs font-semibold uppercase tracking-widest text-white mb-5">Follow</h5>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="<?php echo e(YOUTUBE_URL); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2.5 text-white/60 hover:text-white transition-colors">
                                <svg class="w-4 h-4" viewBox="0 0 576 512" fill="currentColor" aria-hidden="true"><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                                YouTube
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(X_URL); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2.5 text-white/60 hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5 ml-px" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                                X
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-xs text-white/40">
                <p>&copy; <?php echo date('Y'); ?> Zibrah Research Collective. All rights reserved.</p>
                <p>Angles show what words cannot tell</p>
                <p>Ibrahim Ngugi Gatimu</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js?v=<?php echo ASSETS_VERSION; ?>"></script>
</body>
</html>
