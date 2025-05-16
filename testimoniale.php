<?php
$page_title = 'Testimoniale';
include 'includes/header.php';

// Get all testimonials
$testimonials = getTestimonials();
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('/assets/images/testimonials-banner.jpg')">
    <div class="container">
        <h1>Testimoniale</h1>
        <div class="breadcrumbs">
            <a href="/">Acasă</a>
            <span>&gt;</span>
            <span>Testimoniale</span>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonials">
    <div class="container">
        <div class="section-title">
            <h2>Ce spun clienții despre mine</h2>
        </div>
        
        <?php if (count($testimonials) > 0): ?>
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="<?php echo '/uploads/' . $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>" loading="lazy">
                        </div>
                        <div class="testimonial-content">
                            <p class="testimonial-text">"<?php echo $testimonial['content']; ?>"</p>
                            <h3 class="testimonial-name"><?php echo $testimonial['name']; ?></h3>
                            <p class="testimonial-date"><?php echo formatDate($testimonial['created_at']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="testimonials-empty">
                <p>Nu există testimoniale momentan.</p>
            </div>
        <?php endif; ?>
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