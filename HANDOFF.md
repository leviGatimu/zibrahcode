# HANDOFF

## Current Task
Four fixes requested 2026-09-14: blog spacing must match the Quill editor; bot spam on
contact/inquire/newsletter forms; mobile bottom tab bar instead of the sidebar; desktop
header grouped into fewer items.

## Status
Solved — committed locally, NOT pushed. `main` auto-deploys to production (cPanel), so
pushing is the owner's call.

## Progress
- [x] Blog spacing: `.article-body p` now renders like Quill (margin 0, pre-wrap); `space-y-8`
      removed from post.php + editor preview; migration 032 inserts `<p><br></p>` between
      paragraphs of legacy prose posts (verse left untouched — rule: avg ≥ 60 chars/paragraph)
- [x] Spam guard (`includes/spam-guard.php`): honeypot + signed render timestamp (3s min, 24h
      max) + link density + per-IP rate limit (`rate_limit_hits`, migration 033) + duplicate
      message check. Contact spam is stored with status=spam (admin Spam tab, noon purge);
      inquire/newsletter spam is discarded. Sender always sees the normal success message.
- [x] Mobile: bottom tab bar (Home · Book · Blog · Podcast · More) + "More" bottom sheet;
      hamburger/sidebar removed; body gets bottom padding via `body.has-tab-bar`
- [x] Desktop header: Home · About · The Book · Framework · Insights ▾ (Blog, Podcast) ·
      Connect ▾ (Events, Inquire, Contact) · Sign In · Buy Now
- [x] ASSETS_VERSION bumped to 1.0.36
- [x] a4c4751 pushed to production by owner
- [x] A site-wide sizing pass (cf1614e: smaller Tailwind display scale, tighter section padding) was REVERTED in f77bca2 at the owner's request — they want the original scale. Do not re-apply.

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
- 2026-09-14: blog spacing fix + migration, spam guard, mobile bottom bar, header grouping.
