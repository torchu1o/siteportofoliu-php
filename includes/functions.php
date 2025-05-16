<?php
require_once 'config.php';

// Initialize the database if needed
initDatabase();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Convert a string to a URL-friendly slug
 */
function slugify($text) {
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Get categories from the database
 */
function getCategories() {
    $db = getDb();
    $stmt = $db->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll();
}

/**
 * Get albums from the database
 */
function getAlbums($category_slug = null) {
    $db = getDb();
    
    if ($category_slug && $category_slug !== 'toate') {
        $stmt = $db->prepare("
            SELECT a.* FROM albums a
            JOIN categories c ON a.category_id = c.id
            WHERE c.slug = ?
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$category_slug]);
    } else {
        $stmt = $db->query("SELECT * FROM albums ORDER BY created_at DESC");
    }
    
    return $stmt->fetchAll();
}

/**
 * Get photos for an album
 */
function getPhotos($album_id) {
    $db = getDb();
    $stmt = $db->prepare("SELECT * FROM photos WHERE album_id = ? ORDER BY display_order, created_at");
    $stmt->execute([$album_id]);
    return $stmt->fetchAll();
}

/**
 * Get testimonials from the database
 */
function getTestimonials() {
    $db = getDb();
    $stmt = $db->query("SELECT * FROM testimonials ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Save a contact message to the database
 */
function saveContactMessage($name, $email, $phone, $message) {
    $db = getDb();
    $stmt = $db->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $phone, $message]);
}

/**
 * Send an email
 */
function sendEmail($to, $subject, $message) {
    global $site_email;
    
    $headers = "From: $site_email\r\n";
    $headers .= "Reply-To: $site_email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Sanitize user input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Format date
 */
function formatDate($date) {
    return date('d F Y', strtotime($date));
} 