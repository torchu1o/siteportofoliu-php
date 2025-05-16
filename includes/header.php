<?php
require_once 'includes/functions.php';
global $site_title, $site_email, $site_phone, $site_location;

$current_page = basename($_SERVER['SCRIPT_NAME'], '.php');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?> - <?php echo isset($page_title) ? $page_title : 'Fotograf Professional'; ?></title>
    
    <!-- Common CSS -->
    <link rel="stylesheet" href="/css/common.css">
    
    <!-- Page-specific CSS -->
    <?php if (file_exists("css/{$current_page}.css")): ?>
    <link rel="stylesheet" href="/css/<?php echo $current_page; ?>.css">
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <a href="tel:<?php echo $site_phone; ?>" class="phone">
                        <img src="/assets/icons/phone.svg" alt="Telefon">
                        <?php echo $site_phone; ?>
                    </a>
                    <a href="mailto:<?php echo $site_email; ?>" class="email">
                        <img src="/assets/icons/email.svg" alt="Email">
                        <?php echo $site_email; ?>
                    </a>
                    <span class="schedule">
                        <img src="/assets/icons/clock.svg" alt="Program">
                        Luni - Duminică: 08:00 - 18:00
                    </span>
                </div>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" class="facebook">
                        <img src="/assets/icons/facebook.svg" alt="Facebook">
                    </a>
                    <a href="https://instagram.com" target="_blank" class="instagram">
                        <img src="/assets/icons/instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://wa.me/<?php echo str_replace(' ', '', $site_phone); ?>" class="whatsapp">
                        <img src="/assets/icons/whatsapp.svg" alt="WhatsApp">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="/">
                        <img src="/assets/images/logo.png" alt="<?php echo $site_title; ?>">
                    </a>
                </div>
                
                <nav class="main-nav">
                    <button class="menu-toggle" aria-label="Toggle menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul>
                        <li<?php echo $current_page == 'index' ? ' class="active"' : ''; ?>>
                            <a href="/">ACASĂ</a>
                        </li>
                        <li<?php echo $current_page == 'despre' ? ' class="active"' : ''; ?>>
                            <a href="/despre.php">DESPRE MINE</a>
                        </li>
                        <li<?php echo $current_page == 'portofoliu' ? ' class="active"' : ''; ?>>
                            <a href="/portofoliu.php">PORTOFOLIU</a>
                        </li>
                        <li<?php echo $current_page == 'testimoniale' ? ' class="active"' : ''; ?>>
                            <a href="/testimoniale.php">TESTIMONIALE</a>
                        </li>
                        <li<?php echo $current_page == 'blog' ? ' class="active"' : ''; ?>>
                            <a href="/blog.php">BLOG</a>
                        </li>
                        <li<?php echo $current_page == 'contact' ? ' class="active"' : ''; ?>>
                            <a href="/contact.php">CONTACT</a>
                        </li>
                    </ul>
                </nav>
                
                <div class="rezerva-data">
                    <a href="/rezerva.php" class="btn btn-primary">REZERVĂ DATA</a>
                </div>
            </div>
        </div>
    </header>
    
    <main> 