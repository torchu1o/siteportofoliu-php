<?php
$page_title = 'Contact';
include 'includes/header.php';

$success = false;
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $message = isset($_POST['message']) ? sanitize($_POST['message']) : '';
    
    // Validate inputs
    if (empty($name)) {
        $error = 'Numele este obligatoriu.';
    } elseif (empty($email)) {
        $error = 'Email-ul este obligatoriu.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email-ul nu este valid.';
    } elseif (empty($message)) {
        $error = 'Mesajul este obligatoriu.';
    } else {
        // Save to database
        if (saveContactMessage($name, $email, $phone, $message)) {
            // Send email notification
            $subject = "Mesaj nou de contact de la $name";
            $emailBody = "
                <h2>Mesaj nou de contact</h2>
                <p><strong>Nume:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Telefon:</strong> $phone</p>
                <p><strong>Mesaj:</strong></p>
                <p>$message</p>
            ";
            
            sendEmail($site_email, $subject, $emailBody);
            
            $success = true;
        } else {
            $error = 'A apărut o eroare la trimiterea mesajului. Vă rugăm încercați din nou.';
        }
    }
}
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('/assets/images/contact-banner.jpg')">
    <div class="container">
        <h1>Contact</h1>
        <div class="breadcrumbs">
            <a href="/">Acasă</a>
            <span>&gt;</span>
            <span>Contact</span>
        </div>
    </div>
</section>

<!-- Contact Info -->
<section class="section contact-info">
    <div class="container">
        <div class="section-title">
            <h2>Informații de Contact</h2>
        </div>
        
        <div class="contact-cards">
            <div class="contact-card">
                <div class="contact-icon">
                    <img src="/assets/icons/phone.svg" alt="Telefon">
                </div>
                <h3>Telefon</h3>
                <p><a href="tel:<?php echo $site_phone; ?>"><?php echo $site_phone; ?></a></p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">
                    <img src="/assets/icons/email.svg" alt="Email">
                </div>
                <h3>Email</h3>
                <p><a href="mailto:<?php echo $site_email; ?>"><?php echo $site_email; ?></a></p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">
                    <img src="/assets/icons/location.svg" alt="Locație">
                </div>
                <h3>Locație</h3>
                <p><?php echo $site_location; ?></p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">
                    <img src="/assets/icons/whatsapp.svg" alt="WhatsApp">
                </div>
                <h3>WhatsApp</h3>
                <p><a href="https://wa.me/<?php echo str_replace(' ', '', $site_phone); ?>">Trimite-mi un mesaj</a></p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="section contact-form">
    <div class="container">
        <div class="form-container">
            <div class="section-title">
                <h2>Trimite un Mesaj</h2>
            </div>
            
            <?php if ($success): ?>
                <div class="form-success">
                    <p>Mulțumim pentru mesaj! Vă vom contacta în cel mai scurt timp posibil.</p>
                </div>
            <?php else: ?>
                <?php if (!empty($error)): ?>
                    <div class="form-error">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>
                
                <form action="/contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Nume*</label>
                        <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Mesaj*</label>
                        <textarea id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">TRIMITE MESAJ</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section map">
    <div class="container">
        <div class="section-title">
            <h2>Unde mă găsești</h2>
        </div>
    </div>
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21954.21051295586!2d24.136768043921246!3d45.79385578359012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474c678f2d686567%3A0x7846f2a5e59913bd!2sSibiu%2C%20Romania!5e0!3m2!1sen!2s!4v1653212649728!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 