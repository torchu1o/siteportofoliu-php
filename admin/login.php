<?php
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? sanitize($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($username) || empty($password)) {
        $error = 'Toate câmpurile sunt obligatorii.';
    } else {
        $db = getDb();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to dashboard
            redirect('dashboard.php');
        } else {
            $error = 'Numele de utilizator sau parola sunt incorecte.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo $site_title; ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <img src="../assets/images/logo.png" alt="<?php echo $site_title; ?>" class="login-logo">
            <h1>Administrare Site</h1>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Nume de utilizator</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Parolă</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-submit">
                <button type="submit" class="btn btn-primary">Autentificare</button>
            </div>
        </form>
        
        <div class="login-footer">
            <a href="../index.php">← Înapoi la site</a>
        </div>
    </div>
    
    <script>
        // Auto focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
    </script>
</body>
</html> 