<?php
$page_title = 'Verifică Disponibilitatea';
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('/assets/images/reservation-banner.jpg')">
    <div class="container">
        <h1>Verifică Disponibilitatea</h1>
        <div class="breadcrumbs">
            <a href="/">Acasă</a>
            <span>&gt;</span>
            <span>Rezervă Data</span>
        </div>
    </div>
</section>

<!-- Reservation Section -->
<section class="section reservation">
    <div class="container">
        <div class="section-title">
            <h2>Rezervă o Data pentru Ședința Foto</h2>
        </div>
        
        <div class="reservation-content">
            <div class="reservation-info">
                <h3>Cum funcționează?</h3>
                <p>Verifică disponibilitatea mea folosind calendarul de mai jos. Zilele marcate cu culoare sunt rezervate deja.</p>
                <p>După ce găsești o dată care îți convine, poți să mă contactezi folosind una din metodele de mai jos pentru a face o rezervare.</p>
                
                <div class="reservation-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Verifică disponibilitatea</h4>
                            <p>Verifică calendarul pentru a găsi o dată liberă care ți se potrivește.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Contactează-mă</h4>
                            <p>Folosește formularul de contact sau sună-mă pentru a discuta detaliile.</p>
                        </div>
                    </div>
                    
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Confirmă rezervarea</h4>
                            <p>După ce stabilim detaliile, îți voi confirma rezervarea.</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-options">
                    <h3>Contactează-mă pentru rezervare</h3>
                    <div class="contact-buttons">
                        <a href="/contact.php" class="btn btn-primary">Formular de Contact</a>
                        <a href="tel:<?php echo $site_phone; ?>" class="btn btn-secondary">Sună-mă: <?php echo $site_phone; ?></a>
                        <a href="https://wa.me/<?php echo str_replace(' ', '', $site_phone); ?>" class="btn btn-outline">WhatsApp</a>
                    </div>
                </div>
            </div>
            
            <div class="calendar-container">
                <iframe src="https://calendar.google.com/calendar/embed?src=tudorsebastian.foto%40gmail.com&ctz=Europe%2FBucharest&mode=MONTH" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section class="section packages">
    <div class="container">
        <div class="section-title">
            <h2>Pachete Disponibile</h2>
        </div>
        
        <div class="packages-grid">
            <div class="package-card">
                <div class="package-header">
                    <h3>Pachet Standard</h3>
                    <p class="package-price">500 Lei</p>
                </div>
                <div class="package-content">
                    <ul class="package-features">
                        <li>4 ore de fotografiere</li>
                        <li>100+ fotografii editate</li>
                        <li>Livrare în format digital</li>
                        <li>5 fotografii printate (13x18cm)</li>
                    </ul>
                    <div class="package-cta">
                        <a href="/contact.php" class="btn btn-primary">Rezervă Acum</a>
                    </div>
                </div>
            </div>
            
            <div class="package-card featured">
                <div class="package-header">
                    <h3>Pachet Premium</h3>
                    <p class="package-price">900 Lei</p>
                </div>
                <div class="package-content">
                    <ul class="package-features">
                        <li>8 ore de fotografiere</li>
                        <li>200+ fotografii editate</li>
                        <li>Livrare în format digital</li>
                        <li>10 fotografii printate (13x18cm)</li>
                        <li>Album foto (20 pagini)</li>
                    </ul>
                    <div class="package-cta">
                        <a href="/contact.php" class="btn btn-primary">Rezervă Acum</a>
                    </div>
                </div>
            </div>
            
            <div class="package-card">
                <div class="package-header">
                    <h3>Pachet Professional</h3>
                    <p class="package-price">1500 Lei</p>
                </div>
                <div class="package-content">
                    <ul class="package-features">
                        <li>12 ore de fotografiere</li>
                        <li>300+ fotografii editate</li>
                        <li>Livrare în format digital</li>
                        <li>20 fotografii printate (13x18cm)</li>
                        <li>Album foto premium (30 pagini)</li>
                        <li>Sedință pre-eveniment gratuită</li>
                    </ul>
                    <div class="package-cta">
                        <a href="/contact.php" class="btn btn-primary">Rezervă Acum</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 