# HANDOFF

## Current Task
2026-09-18: Brand logo added — favicon set + logo in the site header.

## Status
Solved. Committed and pushed; production auto-deploys from `main`.

## Progress
- [x] Assets derived from `Zibrahcode logo/Transparent/Zibrahcode logo transparent.png` into
      assets/images/: `logo.png` (294x168 lockup, hairlines lightly thickened so they hold at
      56px on 1x screens), `logo-mark.png` (512 emblem), `favicon.ico` (16/32/48/64, transparent,
      strokes thickened per size), `favicon-32x32.png`, `apple-touch-icon.png` (180, white bg),
      `icon-192.png` / `icon-512.png` (manifest, white bg).
- [x] includes/nav.php: text brand replaced by the logo image in the top bar (h-11 / lg:h-14 with
      -my-2 / lg:-my-3 so nav height is unchanged: 103px desktop, 77.5px phone) and in the mobile
      "More" sheet.
- [x] includes/header.php: icon/apple-touch/manifest links (versioned), Organization JSON-LD
      `logo` → logo.png. manifest.json icons → 192/512 PNGs. ASSETS_VERSION 1.0.41.
- [x] Committed and pushed to main.

## Working Notes
The master artwork folder `Zibrahcode logo/` sits untracked in the web root; decide whether to
commit it (e.g. under assets/brand/) or keep it out of the repo.

Follow-ups worth doing: a white/inverted logo variant for the footer (still text on black) and
for the mobile post-page hero where the nav is transparent over a dark image (black strokes
vanish there, only the gold shows — same as the old black text did).

Local dev: Apache vhost http://localhost:8081/ → this repo. On this machine port 3306 is held by
an unrelated Docker container (central-mis-db), so XAMPP's MySQL can't start on its default port.
For this session it was run ad hoc on 3316 (`mysqld --defaults-file=C:/xampp/mysql/bin/my.ini
--port=3316 --standalone`) with DB_HOST temporarily set to `127.0.0.1;port=3316` in config.php,
then reverted. Git Bash mangles `/index`-style URLs in curl; use `/home` or Playwright. Local DB
`zibrah_db` has the live poem post seeded as `3qt-mindset`.

Migrations run automatically on first request after deploy (includes/db.php).

Known, out of scope (not changed):
- config.php commits live DB/SMTP passwords and APP_SECRET to git.
- CSP `connect-src` blocks GA4 beacons to analytics.google.com / www.google.com — Google
  Analytics is probably recording nothing. Add `https://analytics.google.com
  https://www.google.com https://stats.g.doubleclick.net` to connect-src.
- Migration file `021_create_events.php` is missing from the repo (DBs already have it applied),
  so a fresh install would lack the `events` table.
- register.php has no spam guard (bots could create accounts).

## Recently Completed
- 2026-09-16: Blog listing rebuilt as an editorial index (featured post + grid, filter row, no sidebar).
- 2026-09-16: Phone pass: smaller type/spacing scale under 640px, compact angle cards and axiom rows.
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
