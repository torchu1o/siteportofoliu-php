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

// Get all photos in the album
$stmt = $db->prepare("SELECT * FROM photos WHERE album_id = ?");
$stmt->execute([$album_id]);
$photos = $stmt->fetchAll();

// Delete all photos
foreach ($photos as $photo) {
    $file_path = "../" . $photo['file_path'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Delete all photos from database
$stmt = $db->prepare("DELETE FROM photos WHERE album_id = ?");
$stmt->execute([$album_id]);

// Delete album from database
$stmt = $db->prepare("DELETE FROM albums WHERE id = ?");
$stmt->execute([$album_id]);

// Delete album directory
$album_dir = "../uploads/albums/{$album_id}/";
if (file_exists($album_dir)) {
    rmdir($album_dir);
}

// Redirect back to media page
redirect('media.php'); 