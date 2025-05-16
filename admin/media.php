<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$db = getDb();
$message = '';
$error = '';

// Handle album creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'create_album') {
        $title = sanitize($_POST['title']);
        $description = sanitize($_POST['description']);
        $category_id = (int)$_POST['category_id'];
        
        if (empty($title)) {
            $error = 'Titlul albumului este obligatoriu.';
        } else {
            $stmt = $db->prepare("INSERT INTO albums (title, description, category_id) VALUES (?, ?, ?)");
            if ($stmt->execute([$title, $description, $category_id])) {
                $message = 'Albumul a fost creat cu succes.';
            } else {
                $error = 'A apărut o eroare la crearea albumului.';
            }
        }
    }
}

// Get all albums
$stmt = $db->query("SELECT a.*, c.name as category_name, 
                    (SELECT COUNT(*) FROM photos WHERE album_id = a.id) as photo_count 
                    FROM albums a 
                    LEFT JOIN categories c ON a.category_id = c.id 
                    ORDER BY a.created_at DESC");
$albums = $stmt->fetchAll();

// Get all categories
$stmt = $db->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

// Include admin header
include 'includes/header.php';
?>

<div class="media-page">
    <div class="page-header">
        <h1>Gestionare Media</h1>
        <button class="btn btn-primary" onclick="showModal('createAlbumModal')">Album Nou</button>
    </div>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="albums-grid">
        <?php foreach ($albums as $album): ?>
            <div class="album-card">
                <div class="album-cover">
                    <?php
                    // Get first photo from album
                    $stmt = $db->prepare("SELECT file_path FROM photos WHERE album_id = ? ORDER BY id ASC LIMIT 1");
                    $stmt->execute([$album['id']]);
                    $cover_photo = $stmt->fetch();
                    ?>
                    <img src="<?php echo $cover_photo ? $cover_photo['file_path'] : '../assets/images/no-image.jpg'; ?>" 
                         alt="<?php echo $album['title']; ?>">
                </div>
                <div class="album-info">
                    <h3><?php echo $album['title']; ?></h3>
                    <p class="album-category"><?php echo $album['category_name']; ?></p>
                    <p class="album-photos"><?php echo $album['photo_count']; ?> fotografii</p>
                    <div class="album-actions">
                        <a href="album-editare.php?id=<?php echo $album['id']; ?>" class="btn btn-sm">Editează</a>
                        <a href="album-poze.php?id=<?php echo $album['id']; ?>" class="btn btn-sm">Poze</a>
                        <button class="btn btn-sm btn-danger" onclick="deleteAlbum(<?php echo $album['id']; ?>)">Șterge</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Create Album Modal -->
<div id="createAlbumModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Album Nou</h2>
            <button class="close-modal" onclick="hideModal('createAlbumModal')">&times;</button>
        </div>
        <form action="media.php" method="POST" class="modal-form">
            <input type="hidden" name="action" value="create_album">
            
            <div class="form-group">
                <label for="title">Titlu Album</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="category_id">Categorie</label>
                <select id="category_id" name="category_id">
                    <option value="">Selectează categoria</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Descriere</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Creează Album</button>
                <button type="button" class="btn" onclick="hideModal('createAlbumModal')">Anulează</button>
            </div>
        </form>
    </div>
</div>

<script>
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function deleteAlbum(albumId) {
    if (confirm('Sigur doriți să ștergeți acest album? Această acțiune nu poate fi anulată.')) {
        window.location.href = `album-stergere.php?id=${albumId}`;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<?php include 'includes/footer.php'; ?> 