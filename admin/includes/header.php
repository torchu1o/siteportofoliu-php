<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo $site_title; ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <a href="dashboard.php" class="logo">
                <img src="../assets/images/logo.png" alt="<?php echo $site_title; ?>">
            </a>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="albume.php">Albume</a></li>
                <li><a href="media.php">Media</a></li>
                <li><a href="testimoniale.php">Testimoniale</a></li>
                <li><a href="mesaje.php">Mesaje</a></li>
            </ul>
        </nav>
        
        <div class="header-right">
            <div class="user-menu">
                <span class="username"><?php echo $_SESSION['username']; ?></span>
                <div class="dropdown-menu">
                    <a href="profil.php">Profil</a>
                    <a href="logout.php">Deconectare</a>
                </div>
            </div>
        </div>
    </header>
    
    <main class="admin-content"> 