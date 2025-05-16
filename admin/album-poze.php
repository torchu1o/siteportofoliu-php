<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Check if album ID is provided
if (!isset($_GET['id'])) {
    redirect('media.php');
}

$album_id = (int)$_GET['id'];
$db = getDb();
$message = '';
$error = '';

// Get album details
$stmt = $db->prepare("SELECT * FROM albums WHERE id = ?");
$stmt->execute([$album_id]);
$album = $stmt->fetch();

if (!$album) {
    redirect('media.php');
}

// Handle photo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
    $uploaded_files = $_FILES['photos'];
    $success_count = 0;
    $error_count = 0;
    
    // Create upload directory if it doesn't exist
    $upload_dir = "../uploads/albums/{$album_id}/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Process each uploaded file
    for ($i = 0; $i < count($uploaded_files['name']); $i++) {
        if ($uploaded_files['error'][$i] === UPLOAD_ERR_OK) {
            $file_name = $uploaded_files['name'][$i];
            $file_tmp = $uploaded_files['tmp_name'][$i];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            // Generate unique filename
            $new_file_name = uniqid() . '.' . $file_ext;
            $file_path = $upload_dir . $new_file_name;
            
            // Check if file is an image
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_types)) {
                if (move_uploaded_file($file_tmp, $file_path)) {
                    // Save to database
                    $stmt = $db->prepare("INSERT INTO photos (album_id, file_path, original_name) VALUES (?, ?, ?)");
                    if ($stmt->execute([$album_id, "uploads/albums/{$album_id}/" . $new_file_name, $file_name])) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                } else {
                    $error_count++;
                }
            } else {
                $error_count++;
            }
        }
    }
    
    if ($success_count > 0) {
        $message = "{$success_count} fotografii au fost încărcate cu succes.";
    }
    if ($error_count > 0) {
        $error = "{$error_count} fotografii nu au putut fi încărcate.";
    }
}

// Get album photos
$stmt = $db->prepare("SELECT * FROM photos WHERE album_id = ? ORDER BY created_at DESC");
$stmt->execute([$album_id]);
$photos = $stmt->fetchAll();

// Include admin header
include 'includes/header.php';
?>

<div class="album-photos-page">
    <div class="page-header">
        <h1>Fotografii - <?php echo $album['title']; ?></h1>
        <div class="header-actions">
            <form action="album-poze.php?id=<?php echo $album_id; ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="file" name="photos[]" multiple accept="image/*" id="photo-upload" style="display: none;">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('photo-upload').click()">
                    Încarcă Fotografii
                </button>
                <button type="submit" class="btn btn-primary" style="display: none;" id="upload-submit">Salvează</button>
            </form>
            <a href="media.php" class="btn">Înapoi la Albume</a>
        </div>
    </div>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="photos-grid">
        <?php foreach ($photos as $photo): ?>
            <div class="photo-card">
                <div class="photo-preview">
                    <img src="../<?php echo $photo['file_path']; ?>" alt="<?php echo $photo['original_name']; ?>">
                </div>
                <div class="photo-info">
                    <p class="photo-name"><?php echo $photo['original_name']; ?></p>
                    <div class="photo-actions">
                        <button class="btn btn-sm btn-danger" onclick="deletePhoto(<?php echo $photo['id']; ?>)">Șterge</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Show upload button when files are selected
document.getElementById('photo-upload').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('upload-submit').style.display = 'inline-block';
    } else {
        document.getElementById('upload-submit').style.display = 'none';
    }
});

function deletePhoto(photoId) {
    if (confirm('Sigur doriți să ștergeți această fotografie? Această acțiune nu poate fi anulată.')) {
        window.location.href = `photo-stergere.php?id=${photoId}&album_id=<?php echo $album_id; ?>`;
    }
}
</script>

<?php include 'includes/footer.php'; ?> 