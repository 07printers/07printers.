<?php
if (!isset($pageTitle)) $pageTitle = '07 Printers | Best Printing Shop Nazimabad Karachi | Visiting Cards, Nikkah Frames, Flex';
if (!isset($pageDesc)) $pageDesc = '07 Printers - Best printing services in Nazimabad Karachi. Visiting cards, Nikkah frames, photo printing, flex banners, PVC cards, customized gifts & graphic designing. Order on WhatsApp.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <meta name="keywords" content="printing karachi, photocopy nazimabad, graphic designing, customized gifts, flex printing, visiting cards, 07 printers">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <meta name="robots" content="index, follow">
    <meta name="author" content="07 Printers">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_PK">
    <meta name="geo.region" content="PK-SD">
    <meta name="geo.placename" content="Karachi">
    <link rel="canonical" href="https://07printers.com/">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <link rel="icon" href="assets/images/logo.png">
</head>
<body>
    <div id="preloader">
        <div class="loader">
            <div class="loader-ring"></div>
            <img src="assets/images/logo.png" alt="07" style="width:48px; height:48px; object-fit:contain; z-index:2;">
        </div>
    </div>

    <header class="header" id="header">
        <div class="container">
            <div class="header-inner">
                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="07 Printers" class="logo-img">
                    <div class="logo-text">
                        <span class="brand">Printers</span>
                        <span class="tag">Nazimabad, Karachi</span>
                    </div>
                </a>
                
                <nav class="nav" id="nav">
                    <ul class="nav-list">
                        <li><a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='index.php'?'active':''; ?>">Home</a></li>
                        <li><a href="services.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='services.php'?'active':''; ?>">Services</a></li>
                        <li><a href="products.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='products.php'?'active':''; ?>">Products</a></li>
                        <li><a href="about.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='about.php'?'active':''; ?>">About</a></li>
                        <li><a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='contact.php'?'active':''; ?>">Contact</a></li>
                    </ul>
                </nav>
                
                <div class="header-actions">
                    <a href="cart.php" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo getCartCount(); ?></span>
                    </a>
                    <a href="<?php echo whatsappLink('Assalam o Alaikum! I want to place an order from 07 Printers website.'); ?>" 
                       class="btn btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
