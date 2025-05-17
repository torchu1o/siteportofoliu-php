<?php
$page_title = 'Fotograf Profesionist';
include 'includes/header.php';

// Get featured albums for the slider
$db = getDb();
$stmt = $db->query("SELECT * FROM albums ORDER BY created_at DESC LIMIT 5");
$featured_albums = $stmt->fetchAll();
?>

<!-- Hero Slider -->
<section class="hero-slider">
    <div class="slides">
        <?php if (count($featured_albums) > 0): ?>
            <?php foreach ($featured_albums as $album): ?>
                <div class="slide" style="background-image: url('<?php echo $album['cover_image'] ? '/uploads/' . $album['cover_image'] : '/assets/images/default-cover.jpg'; ?>')">
                    <div class="overlay"></div>
                    <div class="slide-content">
                        <h1>Capturând emoții și povești în imagini unice</h1>
                        <p>Bine ați venit în lumea mea captivantă de fotografie de evenimente.</p>
                        <p>Fiecare moment, fiecare privire și fiecare zâmbet spun o poveste, iar eu am pasiunea să le transform în imagini care vor rămâne vesnic.</p>
                        <a href="/portofoliu.php" class="btn btn-primary">PORTOFOLIU</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default slide if no albums -->
            <div class="slide" style="background-image: url('/assets/images/default-cover.jpg')">
                <div class="overlay"></div>
                <div class="slide-content">
                    <h1>Capturând emoții și povești în imagini unice</h1>
                    <p>Bine ați venit în lumea mea captivantă de fotografie de evenimente.</p>
                    <p>Fiecare moment, fiecare privire și fiecare zâmbet spun o poveste, iar eu am pasiunea să le transform în imagini care vor rămâne vesnic.</p>
                    <a href="/portofoliu.php" class="btn btn-primary">PORTOFOLIU</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="slider-controls">
        <button class="prev-slide" aria-label="Previous slide">
            <img src="/assets/icons/arrow-left.svg" alt="Previous">
        </button>
        <button class="next-slide" aria-label="Next slide">
            <img src="/assets/icons/arrow-right.svg" alt="Next">
        </button>
    </div>
    
    <div class="slider-dots"></div>
</section>

<!-- About Section -->
<section class="section about-preview">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>Despre mine</h2>
                <p>Cu o cameră în mână și o pasiune în inimă, sunt dedicat capturării momentelor care aduc bucurie, emoție și frumusețe în viața fiecărei persoane. Fie că este vorba de nunți, petreceri sau alte evenimente speciale, îmi propun să surprind autenticitatea și magia fiecărui moment.</p>
                <p>Sunt onorat să fiu martorul și povestitorul fiecărei călătorii unice.</p>
                <a href="/despre.php" class="btn btn-outline">AFLĂ MAI MULTE</a>
            </div>
            <div class="about-image">
                <img src="/assets/images/photographer.jpg" alt="Fotograf">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section services">
    <div class="container">
        <div class="section-title">
            <h2>Servicii</h2>
        </div>
        
        <div class="service-cards">
            <div class="service-card">
                <img src="/assets/images/wedding.jpg" alt="Nuntă" class="service-icon">
                <h3>Fotografie de Nuntă</h3>
                <p>Captez toate momentele speciale din ziua nunții voastre, de la primele pregătiri până la ultimul dans.</p>
            </div>
            
            <div class="service-card">
                <img src="/assets/images/couple.jpg" alt="Cununie" class="service-icon">
                <h3>Fotografie de Cununie</h3>
                <p>Imortalizez ceremonia religioasă cu respect și discreție, capturând emoțiile și tradițiile importante.</p>
            </div>
            
            <div class="service-card">
                <img src="/assets/images/majorate.jpg" alt="Majorat" class="service-icon">
                <h3>Majorate</h3>
                <p>Ședințe foto creative de majorat , într-un stil nonconformist, pentru amintiri cu adevărat unice.</p>
            </div>
        </div>
    </div>
</section>

<!-- Recent Work -->
<section class="section recent-work">
    <div class="container">
        <div class="section-title">
            <h2>Lucrări Recente</h2>
        </div>
        
        <div class="portfolio-preview">
            <?php 
            $stmt = $db->query("SELECT albums.*, categories.name as category_name 
                                FROM albums 
                                JOIN categories ON albums.category_id = categories.id 
                                ORDER BY albums.created_at DESC LIMIT 3");
            $recent_albums = $stmt->fetchAll();
            
            if (count($recent_albums) > 0):
                foreach ($recent_albums as $album):
            ?>
                <div class="portfolio-item">
                    <a href="/album.php?slug=<?php echo $album['slug']; ?>">
                        <div class="portfolio-image">
                            <img src="<?php echo $album['cover_image'] ? '/uploads/' . $album['cover_image'] : '/assets/images/default-cover.jpg'; ?>" alt="<?php echo $album['title']; ?>">
                            <div class="portfolio-overlay">
                                <span>Vezi mai multe</span>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h3><?php echo $album['title']; ?></h3>
                            <span class="category"><?php echo $album['category_name']; ?></span>
                        </div>
                    </a>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="portfolio-empty">
                    <p>Nu există albume disponibile momentan.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="portfolio-more">
            <a href="/portofoliu.php" class="btn btn-primary">VEZI TOT PORTOFOLIUL</a>
        </div>
    </div>
</section>

<!-- Testimonials Preview -->
<section class="section testimonials-preview" style="background-image: url('/assets/images/testimonials-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="section-title">
            <h2>Ce spun clienții</h2>
        </div>
        
        <div class="testimonials-slider">
            <?php 
            $stmt = $db->query("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 5");
            $testimonials = $stmt->fetchAll();
            
            if (count($testimonials) > 0):
                foreach ($testimonials as $testimonial):
            ?>
                <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <div class="testimonial-image">
                            <img src="<?php echo '/uploads/' . $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                        </div>
                        <div class="testimonial-text">
                            <p>"<?php echo $testimonial['content']; ?>"</p>
                            <h4><?php echo $testimonial['name']; ?></h4>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <div class="testimonial-text">
                            <p>"Recomand cu drag. Seriozitate maximă!"</p>
                            <h4>Client Fericit</h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="testimonials-more">
            <a href="/testimoniale.php" class="btn btn-outline">VEZI TOATE TESTIMONIALELE</a>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="section contact-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Hai să discutăm despre proiectul tău!</h2>
            <p>Sunt mereu deschis să discut despre noi proiecte și să ajut în captarea celor mai frumoase momente din viața ta.</p>
            <div class="cta-buttons">
                <a href="/contact.php" class="btn btn-primary">CONTACTEAZĂ-MĂ</a>
                <a href="/rezerva.php" class="btn btn-secondary">VERIFICĂ DISPONIBILITATEA</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 