    <!-- FOOTER -->
    <?php $footerUser = currentUser(); ?>
    <footer class="bg-brand-black text-white pt-16 md:pt-24 pb-10">
        <div class="section-container">

            <div class="grid md:grid-cols-2 gap-12 md:gap-20 pb-14 md:pb-20 border-b border-white/10">
                <div>
                    <a href="/index.php" class="inline-block font-bold tracking-[0.4em] text-sm uppercase text-white">ZIBRAH CODE<span class="text-brand-gold text-[9px] align-top ml-1">™</span></a>
                    <p class="mt-6 text-2xl md:text-3xl serif italic font-light leading-snug text-white/90 max-w-sm">The Geometry of Truth and Wisdom</p>
                    <p class="mt-3 text-base text-white/50 font-light">A book and framework by Ibrahim Ngugi.</p>
                </div>

                <div class="md:max-w-md md:justify-self-end w-full">
                    <p class="text-white/90 text-base mb-1">New essays, by email.</p>
                    <p class="text-white/50 text-sm font-light leading-relaxed mb-6">Occasional writing on truth, perception and belief, sent when there is something worth reading. Unsubscribe any time.</p>
                    <form action="/actions/newsletter-subscribe" method="POST" class="flex border-b border-white/30 focus-within:border-brand-gold transition-colors">
                        <?php echo csrfField(); ?>
                        <?php echo spamGuardFields(); ?>
                        <input type="hidden" name="source" value="footer">
                        <label for="footer-email" class="sr-only">Email address</label>
                        <input id="footer-email" type="email" name="email" required autocomplete="email" placeholder="you@example.com"
                            class="flex-1 min-w-0 bg-transparent py-3 text-base text-white placeholder-white/30 focus:outline-none">
                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-brand-gold hover:text-white transition-colors pl-6 py-3">Subscribe</button>
                    </form>
                </div>
            </div>

            <nav aria-label="Footer" class="py-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <ul class="flex flex-wrap gap-x-7 gap-y-3 text-sm text-white/70">
                    <li><a href="/book.php" class="hover:text-white transition-colors">The Book</a></li>
                    <li><a href="/about.php" class="hover:text-white transition-colors">The Author</a></li>
                    <li><a href="/framework.php" class="hover:text-white transition-colors">Framework</a></li>
                    <li><a href="/blog.php" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="/podcast.php" class="hover:text-white transition-colors">Podcast</a></li>
                    <li><a href="/events.php" class="hover:text-white transition-colors">Events</a></li>
                    <li><a href="/inquire.php" class="hover:text-white transition-colors">Inquire</a></li>
                    <li><a href="/contact.php" class="hover:text-white transition-colors">Contact</a></li>
                </ul>
                <ul class="flex flex-wrap gap-x-7 gap-y-3 text-sm text-white/70">
                    <li><a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="hover:text-white transition-colors">Buy on Amazon<span class="text-white/40 ml-1" aria-hidden="true">&#8599;</span></a></li>
                    <li><a href="<?php echo e(YOUTUBE_URL); ?>" target="_blank" rel="noopener" class="hover:text-white transition-colors">YouTube<span class="text-white/40 ml-1" aria-hidden="true">&#8599;</span></a></li>
                    <li><a href="<?php echo e(X_URL); ?>" target="_blank" rel="noopener" class="hover:text-white transition-colors">X<span class="text-white/40 ml-1" aria-hidden="true">&#8599;</span></a></li>
                </ul>
            </nav>

            <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-white/40">
                <p>&copy; <?php echo date('Y'); ?> Ibrahim Ngugi Gatimu</p>
                <?php if ($footerUser): ?>
                    <a href="/account/index.php" class="hover:text-white transition-colors">Your account</a>
                <?php else: ?>
                    <a href="/login.php" class="hover:text-white transition-colors">Sign in</a>
                <?php endif; ?>
            </div>

        </div>
    </footer>

    <script src="/assets/js/main.js?v=<?php echo ASSETS_VERSION; ?>"></script>
</body>
</html>
