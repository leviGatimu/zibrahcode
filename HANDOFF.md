# HANDOFF

## Current Task
2026-09-16: Footer, third pass ("still ain't professional").

## Status
Solved, uncommitted. Awaiting go-ahead to commit/push.

## Progress
- [x] Same content, balanced 12-col grid: brand + description + newsletter (5) | Explore (2) |
      Company (2) | Follow (2, YouTube/X as text links with inline icons). All type small and
      regular weight; white column headings; white Join button; no italics, no bordered icon
      boxes, no gold hairline, no big quote. Bottom bar: three plain 12px lines at 40% white.
- [x] Verified 1280/390: no overflow; link columns pair up on phones.

## Working Notes
Local dev: Apache vhost http://localhost:8081/ → this repo (added to
C:\xampp\apache\conf\extra\httpd-vhosts.conf; `Listen 8081` in httpd.conf). `.htaccess`
HTTPS redirect now skips localhost. Local DB `zibrah_db` has the live poem post seeded as
`3qt-mindset` for testing. Screenshots via Playwright helper in the session scratchpad.

Migrations run automatically on first request after deploy (includes/db.php). 032 and 033
were re-tested from scratch on a DB copy via runMigrations().

Known, out of scope (not changed):
- config.php commits live DB/SMTP passwords and APP_SECRET to git.
- CSP `connect-src` blocks GA4 beacons to analytics.google.com / www.google.com — Google
  Analytics is probably recording nothing. Add `https://analytics.google.com
  https://www.google.com https://stats.g.doubleclick.net` to connect-src.
- Migration file `021_create_events.php` is missing from the repo (DBs already have it applied),
  so a fresh install would lack the `events` table.
- register.php has no spam guard (bots could create accounts).

## Recently Completed
- 2026-09-16: Footer rebalanced into a quiet four-column layout (third pass).
- 2026-09-16: Home page sections restyled on the shared section system; hero tidied.
- 2026-09-16: Book + author pages rebuilt as sectioned pages on the framework system (after two rejected one-column 'brief' versions).
- 2026-09-16: Fonts: Poppins (cover face) for brand/headings/UI + Source Serif 4 for post bodies only; Inter dropped.
- 2026-09-16: Footer restyled on its original structure (owner rejected the colophon layout).
- 2026-09-16: Dash purge across public copy + migration 034; home section separator lines removed.
- 2026-09-15: Home page rebuilt on one section system (eyebrow → serif h2 4xl/5xl → light body → CTA; alternating white/gray-50/black). Removed dead cruft: undefined pattern-bg/zebra-wedge classes, the 'Details' button whose modal never existed (modalBook state dropped from header.php). Angle devices trimmed back to the framework + home cards only (footer strip, page-header marks, book strip removed; angleScale() deleted).
- 2026-09-14: Mobile pass — vertical rhythm is now responsive on all public pages (unprefixed py/pt/pb/mb/mt 40/32/24/20/16 get phone values, original kept behind md:), home book/asset images fit the phone width, footer angle strip fits one row. Desktop values unchanged (owner rejected desktop-scale changes earlier).
- 2026-09-14: Angle glyph made a shared brand device: angleGlyph()/angleStates()/angleScale() in includes/functions.php + includes/angle-cards.php (home + framework). Home: scroll-reveal animations and spinning ring removed; A/W/Q cards replaced by Open/Hardening/Closed. Book: compact scale under the argument. Footer: scale on every page. Blog/Podcast/Events/Contact/Inquire headers: small gold angle mark.
- 2026-09-14: Framework page rebuilt around the model diagram (assets/images/blog.png): hero + diagram, 'reading the angle' (open/hardening/closed with inline SVG angle glyphs), five axioms in an indexed dark section with sticky TOC, where it applies, further reading (two foundational posts).
- 2026-09-14: Book page rebuilt (hero with uncropped cover, argument, five axioms from includes/axioms.php, audiences, details, author teaser, CTA). Nav: Book before The Author. auther.jpeg <img> tags carry ?v=ASSETS_VERSION so the new portrait bypasses the 7-day image cache (OG URL left plain because header.php reads the file's size from disk).
- 2026-09-14: About page rebuilt around portfolio content + new portrait (ASSETS_VERSION 1.0.37).
- 2026-09-14: blog spacing fix + migration, spam guard, mobile bottom bar, header grouping.
