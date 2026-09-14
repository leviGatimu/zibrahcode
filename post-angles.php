<?php
// Legacy URL — 301 redirect to the new database-backed post template to preserve indexed search-engine equity.
header('HTTP/1.1 301 Moved Permanently');
header('Location: /post.php?slug=angles-show-what-words-cannot-tell');
exit;
