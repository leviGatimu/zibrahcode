<?php
/**
 * Shared <head> + opening <body> + nav.
 * Caller sets before including: $pageTitle, $pageDescription, $canonicalPath,
 * optional $ogImage, optional $activeNav, optional $extraJsonLd (array of JSON strings).
 */
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? META_DESCRIPTION;
$canonicalPath = $canonicalPath ?? '/';
$ogImage = $ogImage ?? SITE_URL . '/assets/images/Front page.png';
$activeNav = $activeNav ?? '';
$extraJsonLd = $extraJsonLd ?? [];
$robotsMeta = $robotsMeta ?? 'index, follow';
$canonicalUrl = rtrim(SITE_URL, '/') . '/' . ltrim($canonicalPath, '/');

// Read the real dimensions of whichever image this page is using for OG/Twitter
// previews, instead of assuming every page's image is a 1200x630 landscape —
// several pages use square/portrait images and a wrong declared size risks a
// badly-cropped social preview.
$ogImageLocalPath = __DIR__ . '/../' . ltrim(str_replace(rtrim(SITE_URL, '/'), '', $ogImage), '/');
$ogImageSize = @getimagesize($ogImageLocalPath);
$ogImageWidth = $ogImageSize[0] ?? 1200;
$ogImageHeight = $ogImageSize[1] ?? 630;
$twitterCardType = ($ogImageWidth / max($ogImageHeight, 1)) >= 1.3 ? 'summary_large_image' : 'summary';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1HWX42NVM8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-1HWX42NVM8');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="author" content="<?php echo e(AUTHOR_NAME); ?>">
    <meta name="robots" content="<?php echo e($robotsMeta); ?>">
    <link rel="canonical" href="<?php echo e($canonicalUrl); ?>">

    <!-- OPEN GRAPH -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e(SITE_NAME); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:image" content="<?php echo e($ogImage); ?>">
    <meta property="og:image:width" content="<?php echo (int) $ogImageWidth; ?>">
    <meta property="og:image:height" content="<?php echo (int) $ogImageHeight; ?>">
    <meta property="og:url" content="<?php echo e($canonicalUrl); ?>">
    <meta property="og:locale" content="en_US">

    <!-- TWITTER / X CARD -->
    <meta name="twitter:card" content="<?php echo e($twitterCardType); ?>">
    <meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($pageDescription); ?>">
    <meta name="twitter:image" content="<?php echo e($ogImage); ?>">

    <!-- JSON-LD: WebSite + Sitelinks Signal -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo SITE_NAME; ?>",
        "alternateName": ["ZibrahCode", "Zibrah Code"],
        "url": "<?php echo SITE_URL; ?>/",
        "description": "Zibrah Code is an original geometric model by Ibrahim Ngugi that separates truth and perception to reveal how belief, conflict, and leadership decisions evolve.",
        "inLanguage": "en",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo SITE_URL; ?>/blog.php?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- JSON-LD: Organization (Brand Identity — fixes "Did you mean Zebra?") -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Zibrah Code",
        "alternateName": ["ZibrahCode", "Zibrah Code™"],
        "url": "<?php echo SITE_URL; ?>/",
        "logo": "<?php echo SITE_URL; ?>/assets/images/favicon.ico",
        "description": "Zibrah Code — spelled Z-I-B-R-A-H — is an original intellectual brand and geometric wisdom model created by Ibrahim Ngugi. It is not related to Zebra or any animal brand.",
        "founder": {
            "@type": "Person",
            "name": "Ibrahim Ngugi",
            "jobTitle": "Author & Audit Practitioner",
            "sameAs": "<?php echo AMAZON_URL; ?>"
        },
        "sameAs": ["<?php echo AMAZON_URL; ?>", "<?php echo YOUTUBE_URL; ?>", "<?php echo X_URL; ?>"]
    }
    </script>

    <!-- JSON-LD: Brand -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Brand",
        "name": "Zibrah Code",
        "alternateName": "ZibrahCode",
        "description": "Zibrah Code (Z-I-B-R-A-H) is an original geometric wisdom model by Ibrahim Ngugi. Unrelated to any product or brand spelled Zebra. Zibrah Code is about truth, perception, belief, and leadership geometry.",
        "url": "<?php echo SITE_URL; ?>/"
    }
    </script>

    <?php foreach ($extraJsonLd as $jsonLdBlock): ?>
    <script type="application/ld+json"><?php echo $jsonLdBlock; ?></script>
    <?php endforeach; ?>

    <!-- Resource Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://unpkg.com">

    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/assets/images/favicon.ico">
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@200;300;400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            black: '#1A1A1A',
                            true: '#1A1A1A',
                            white: '#FFFFFF',
                            gold: '#B89441',
                            'gold-light': '#D4B876',
                            'gold-dark': '#8A6F2E',
                            gray: {
                                50: '#FAFAFA', 100: '#F2F2F2', 200: '#E5E5E5', 300: '#D4D4D4',
                                400: '#A3A3A3', 500: '#737373', 600: '#525252', 700: '#404040',
                                800: '#262626', 900: '#171717'
                            },
                            // legacy aliases kept during migration so old markup keeps working
                            navy: '#1A1A1A',
                            cream: '#FAFAFA',
                            slate: '#525252'
                        }
                    },
                    fontFamily: {
                        serif: ['"EB Garamond"', 'serif'],
                        display: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo ASSETS_VERSION; ?>">
    <meta name="csrf-token" content="<?php echo e(csrfToken()); ?>">
</head>

<body x-data="{ modalBook: false, scrolled: false, moreSheet: false }" @scroll.window="scrolled = (window.pageYOffset > 50)"
    class="has-tab-bar antialiased selection:bg-brand-gold/20 selection:text-brand-gold">

    <?php require __DIR__ . '/nav.php'; ?>
    <?php require __DIR__ . '/flash.php'; ?>
