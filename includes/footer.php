    </main>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="/assets/images/logo.png" alt="<?php echo $site_title; ?>">
                </div>
                
                <div class="footer-info">
                    <div class="footer-contact">
                        <h3>Contact</h3>
                        <address>
                            <p><?php echo $site_location; ?></p>
                            <p>Tel: <a href="tel:<?php echo $site_phone; ?>"><?php echo $site_phone; ?></a></p>
                            <p>Email: <a href="mailto:<?php echo $site_email; ?>"><?php echo $site_email; ?></a></p>
                        </address>
                    </div>
                    
                    <div class="footer-menu">
                        <h3>Meniu</h3>
                        <ul>
                            <li><a href="/">Acasă</a></li>
                            <li><a href="/despre.php">Despre mine</a></li>
                            <li><a href="/portofoliu.php">Portofoliu</a></li>
                            <li><a href="/testimoniale.php">Testimoniale</a></li>
                            <li><a href="/blog.php">Blog</a></li>
                            <li><a href="/contact.php">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-social">
                        <h3>Social</h3>
                        <div class="social-links">
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
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $site_title; ?>. Toate drepturile rezervate.</p>
            </div>
        </div>
        
        <!-- WhatsApp floating button -->
        <a href="https://wa.me/<?php echo str_replace(' ', '', $site_phone); ?>" class="whatsapp-float">
            <img src="/assets/icons/whatsapp.svg" alt="WhatsApp">
            <span>Scrie-mi pe WhatsApp!</span>
        </a>
    </footer>
    
    <!-- Common JS -->
    <script src="/js/common.js"></script>
    
    <!-- Page-specific JS -->
    <?php if (file_exists("js/{$current_page}.js")): ?>
    <script src="/js/<?php echo $current_page; ?>.js"></script>
    <?php endif; ?>
</body>
</html> 