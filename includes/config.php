<?php
// Load environment variables from .env file
function loadEnv($path = '.env') {
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Remove quotes if present
        if (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) {
            $value = substr($value, 1, -1);
        }

        putenv("$name=$value");
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }

    return true;
}

// Load environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    loadEnv($envFile);
} else if (file_exists(__DIR__ . '/../.env.example')) {
    // Copy example file if .env doesn't exist
    copy(__DIR__ . '/../.env.example', $envFile);
    loadEnv($envFile);
}

// Database configuration
$db_connection = getenv('DB_CONNECTION') ?: 'sqlite';
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_DATABASE') ?: 'database.sqlite';
$db_user = getenv('DB_USERNAME') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';

// Site configuration
$site_title = getenv('SITE_TITLE') ?: 'Tudor Sebastian Fotograf';
$site_email = getenv('SITE_EMAIL') ?: 'tudor.torcica@gmail.com';
$site_phone = getenv('SITE_PHONE') ?: '0741940601';
$site_location = getenv('SITE_LOCATION') ?: 'Sibiu, Romania';

// Connect to database
function getDb() {
    global $db_connection, $db_host, $db_name, $db_user, $db_pass;
    
    try {
        if ($db_connection === 'sqlite') {
            $dbPath = __DIR__ . '/../' . $db_name;
            $pdo = new PDO("sqlite:{$dbPath}");
        } else {
            $pdo = new PDO(
                "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
                $db_user,
                $db_pass
            );
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch(PDOException $e) {
        // Log error instead of exposing it
        error_log('Database connection error: ' . $e->getMessage());
        return null;
    }
}

// Initialize database tables if they don't exist
function initDatabase() {
    $db = getDb();
    
    if (!$db) {
        return false;
    }
    
    // Categories table
    $db->exec("CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Albums table
    $db->exec("CREATE TABLE IF NOT EXISTS albums (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        category_id INTEGER,
        description TEXT,
        cover_image TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    )");
    
    // Photos table
    $db->exec("CREATE TABLE IF NOT EXISTS photos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        album_id INTEGER NOT NULL,
        filename TEXT NOT NULL,
        title TEXT,
        description TEXT,
        display_order INTEGER DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
    )");
    
    // Testimonials table
    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        image TEXT NOT NULL,
        content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Contact messages table
    $db->exec("CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT,
        message TEXT NOT NULL,
        is_read BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Users table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        email TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default categories if the table is empty
    $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
    $row = $stmt->fetch();
    
    if ($row['count'] == 0) {
        $categories = [
            ['name' => 'Toate', 'slug' => 'toate'],
            ['name' => 'Cununie', 'slug' => 'cununie'],
            ['name' => 'Nuntă', 'slug' => 'nunta'],
            ['name' => 'Trash The Dress', 'slug' => 'trash-the-dress']
        ];
        
        $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        foreach ($categories as $category) {
            $stmt->execute([$category['name'], $category['slug']]);
        }
    }
    
    // Insert default admin user if the table is empty
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $row = $stmt->fetch();
    
    if ($row['count'] == 0) {
        $username = getenv('ADMIN_USERNAME') ?: 'admin';
        $password = getenv('ADMIN_PASSWORD') ?: 'admin';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
    }
    
    return true;
} 