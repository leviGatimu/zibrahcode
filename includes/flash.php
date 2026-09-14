<?php
$flashes = flashGet();
if ($flashes): ?>
    <div id="toast-container" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-full max-w-lg px-6 space-y-3 pointer-events-none"></div>
    <script>
        (function () {
            var flashes = <?php echo json_encode($flashes); ?>;
            var container = document.getElementById('toast-container');

            function showToast(flash) {
                var el = document.createElement('div');
                el.className = 'pointer-events-auto flex items-center justify-between gap-4 p-5 shadow-2xl transition-all duration-500 ease-out opacity-0 -translate-y-3 ' +
                    (flash.type === 'success' ? 'bg-brand-black text-white border border-brand-gold' : 'bg-red-50 border border-red-300 text-red-700');

                var text = document.createElement('span');
                text.textContent = flash.message;
                el.appendChild(text);

                var closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.setAttribute('aria-label', 'Dismiss');
                closeBtn.className = 'flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity';
                closeBtn.textContent = '✕';
                closeBtn.addEventListener('click', function () { dismiss(el); });
                el.appendChild(closeBtn);

                container.appendChild(el);
                requestAnimationFrame(function () {
                    el.classList.remove('opacity-0', '-translate-y-3');
                });

                var timer = setTimeout(function () { dismiss(el); }, 4000);
                el.addEventListener('mouseenter', function () { clearTimeout(timer); });
            }

            function dismiss(el) {
                el.classList.add('opacity-0', '-translate-y-3');
                setTimeout(function () { el.remove(); }, 500);
            }

            flashes.forEach(function (flash, i) {
                setTimeout(function () { showToast(flash); }, i * 200);
            });
        })();
    </script>
<?php endif; ?>
