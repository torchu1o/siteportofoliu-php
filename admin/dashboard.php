<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Get counts for dashboard
$db = getDb();

$stmt = $db->query("SELECT COUNT(*) as count FROM albums");
$albums_count = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM photos");
$photos_count = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM testimonials");
$testimonials_count = $stmt->fetch()['count'];

$stmt = $db->query("SELECT COUNT(*) as count FROM messages WHERE is_read = 0");
$unread_messages_count = $stmt->fetch()['count'];

// Get recent items
$stmt = $db->query("SELECT * FROM albums ORDER BY created_at DESC LIMIT 5");
$recent_albums = $stmt->fetchAll();

$stmt = $db->query("SELECT m.*, 
                    CASE WHEN LENGTH(m.message) > 100 THEN SUBSTRING(m.message, 1, 100) || '...' ELSE m.message END as short_message 
                    FROM messages m 
                    ORDER BY created_at DESC LIMIT 5");
$recent_messages = $stmt->fetchAll();

// Include admin header
include 'includes/header.php';
?>

<div class="dashboard">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Bine ai venit, <?php echo $_SESSION['username']; ?>!</p>
    </div>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <img src="../assets/icons/album.svg" alt="Albume">
            </div>
            <div class="stat-content">
                <h3>Albume</h3>
                <p class="stat-number"><?php echo $albums_count; ?></p>
            </div>
            <a href="albume.php" class="stat-link">Gestionează</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <img src="../assets/icons/photo.svg" alt="Fotografii">
            </div>
            <div class="stat-content">
                <h3>Fotografii</h3>
                <p class="stat-number"><?php echo $photos_count; ?></p>
            </div>
            <a href="media.php" class="stat-link">Gestionează</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <img src="../assets/icons/testimonial.svg" alt="Testimoniale">
            </div>
            <div class="stat-content">
                <h3>Testimoniale</h3>
                <p class="stat-number"><?php echo $testimonials_count; ?></p>
            </div>
            <a href="testimoniale.php" class="stat-link">Gestionează</a>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <img src="../assets/icons/message.svg" alt="Mesaje">
            </div>
            <div class="stat-content">
                <h3>Mesaje Necitite</h3>
                <p class="stat-number"><?php echo $unread_messages_count; ?></p>
            </div>
            <a href="mesaje.php" class="stat-link">Gestionează</a>
        </div>
    </div>
    
    <div class="dashboard-sections">
        <div class="section">
            <div class="section-header">
                <h2>Albume Recente</h2>
                <a href="albume.php" class="btn btn-sm">Vezi Toate</a>
            </div>
            
            <div class="section-content">
                <?php if (count($recent_albums) > 0): ?>
                    <div class="table-responsive">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Titlu</th>
                                    <th>Categorie</th>
                                    <th>Data Creării</th>
                                    <th>Acțiuni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_albums as $album): 
                                    // Get category name
                                    $stmt = $db->prepare("SELECT name FROM categories WHERE id = ?");
                                    $stmt->execute([$album['category_id']]);
                                    $category = $stmt->fetch();
                                    $category_name = $category ? $category['name'] : 'Fără categorie';
                                ?>
                                    <tr>
                                        <td><?php echo $album['title']; ?></td>
                                        <td><?php echo $category_name; ?></td>
                                        <td><?php echo formatDate($album['created_at']); ?></td>
                                        <td class="actions">
                                            <a href="album-editare.php?id=<?php echo $album['id']; ?>" class="btn btn-sm">Editează</a>
                                            <a href="album-poze.php?id=<?php echo $album['id']; ?>" class="btn btn-sm">Poze</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="empty-message">Nu există albume momentan.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                <h2>Mesaje Recente</h2>
                <a href="mesaje.php" class="btn btn-sm">Vezi Toate</a>
            </div>
            
            <div class="section-content">
                <?php if (count($recent_messages) > 0): ?>
                    <div class="messages-list">
                        <?php foreach ($recent_messages as $message): ?>
                            <div class="message-card <?php echo $message['is_read'] ? '' : 'unread'; ?>">
                                <div class="message-header">
                                    <h3><?php echo $message['name']; ?></h3>
                                    <span class="message-date"><?php echo formatDate($message['created_at']); ?></span>
                                </div>
                                <div class="message-contact">
                                    <span class="message-email"><?php echo $message['email']; ?></span>
                                    <?php if (!empty($message['phone'])): ?>
                                        <span class="message-phone"><?php echo $message['phone']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="message-text"><?php echo $message['short_message']; ?></p>
                                <div class="message-actions">
                                    <a href="mesaj.php?id=<?php echo $message['id']; ?>" class="btn btn-sm">Vezi Mesaj</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-message">Nu există mesaje momentan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 