document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});

function toggleBookmark(button, type, id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    fetch('/actions/bookmark-toggle', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}&csrf_token=${encodeURIComponent(csrfToken)}`
    })
        .then(res => res.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            if (data.bookmarked) {
                button.classList.add('text-brand-gold');
                button.dataset.bookmarked = '1';
            } else {
                button.classList.remove('text-brand-gold');
                button.dataset.bookmarked = '0';
            }
        })
        .catch(() => {});
}

function toggleLike(button, type, id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    fetch('/actions/like-toggle', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}&csrf_token=${encodeURIComponent(csrfToken)}`
    })
        .then(res => res.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            const outline = button.querySelector('.icon-heart-outline');
            const filled = button.querySelector('.icon-heart-filled');
            const count = button.querySelector('.like-count');
            if (data.liked) {
                button.classList.add('text-brand-gold');
                outline.classList.add('hidden');
                filled.classList.remove('hidden');
            } else {
                button.classList.remove('text-brand-gold');
                filled.classList.add('hidden');
                outline.classList.remove('hidden');
            }
            if (count) { count.textContent = data.count; }
        })
        .catch(() => {});
}

function copyShareLink(url, feedbackEl) {
    navigator.clipboard.writeText(url).then(() => {
        if (feedbackEl) {
            const original = feedbackEl.textContent;
            feedbackEl.textContent = 'Copied!';
            setTimeout(() => { feedbackEl.textContent = original; }, 1500);
        }
    }).catch(() => {});
}
