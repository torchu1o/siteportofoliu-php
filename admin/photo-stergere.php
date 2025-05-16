<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Check if photo ID and album ID are provided
if (!isset($_GET['id']) || !isset($_GET['album_id'])) {
    redirect('media.php');
}

$photo_id = (int)$_GET['id'];
$album_id = (int)$_GET['album_id'];
$db = getDb();

// Get photo details
$stmt = $db->prepare("SELECT * FROM photos WHERE id = ? AND album_id = ?");
$stmt->execute([$photo_id, $album_id]);
$photo = $stmt->fetch();

if ($photo) {
    // Delete file from server
    $file_path = "../" . $photo['file_path'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Delete from database
    $stmt = $db->prepare("DELETE FROM photos WHERE id = ?");
    $stmt->execute([$photo_id]);
}

// Redirect back to album photos
redirect("album-poze.php?id={$album_id}"); 