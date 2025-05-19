<?php
require_once 'includes/functions.php';

// Get album slug from URL
$album_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($album_slug)) {
    // Redirect to portfolio if no slug provided
    redirect('/portofoliu.php');
}

// Get album details
$db = getDb();
$stmt = $db->prepare("SELECT * FROM albums WHERE slug = ?");
$stmt->execute([$album_slug]);
$album = $stmt->fetch();

if (!$album) {
    // Redirect to portfolio if album not found
    redirect('/portofoliu.php');
}

// Get album photos
$stmt = $db->prepare("SELECT * FROM photos WHERE album_id = ? ORDER BY created_at ASC");
$stmt->execute([$album['id']]);
$photos = $stmt->fetchAll();

// Get category
$stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$album['category_id']]);
$category = $stmt->fetch();

$page_title = $album['title'];
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('<?php echo $album['cover_image'] ? '/uploads/' . $album['cover_image'] : '/assets/images/portfolio-banner.jpg'; ?>')">
    <div class="container">
        <h1><?php echo $album['title']; ?></h1>
        <div class="breadcrumbs">
            <a href="/">Acasă</a>
            <span>&gt;</span>
            <a href="/portofoliu.php">Portofoliu</a>
            <span>&gt;</span>
            <span><?php echo $album['title']; ?></span>
        </div>
    </div>
</section>

<!-- Album Details -->
<section class="section album-details">
    <div class="container">
        <div class="album-info">
            <?php if ($category): ?>
                <div class="album-category">
                    <a href="/portofoliu.php?categorie=<?php echo $category['slug']; ?>"><?php echo $category['name']; ?></a>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($album['description'])): ?>
                <div class="album-description">
                    <?php echo nl2br($album['description']); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Photo Gallery -->
        <div class="photo-gallery">
            <?php if (count($photos) > 0): ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="gallery-item">
                        <a href="/<?php echo htmlspecialchars($photo['file_path']); ?>" class="lightbox" data-caption="<?php echo htmlspecialchars($photo['title']); ?>">
                            <img src="/<?php echo htmlspecialchars($photo['file_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" loading="lazy">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="gallery-empty">
                    <p>Nu există fotografii disponibile pentru acest album momentan.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Back to Portfolio -->
        <div class="back-to-portfolio">
            <a href="/portofoliu.php" class="btn btn-outline">ÎNAPOI LA PORTOFOLIU</a>
        </div>
    </div>
</section>

<!-- Related Albums -->
<section class="section related-albums">
    <div class="container">
        <div class="section-title">
            <h2>Alte Albume</h2>
        </div>
        
        <div class="portfolio-preview">
            <?php
            // Get related albums from the same category
            $stmt = $db->prepare("
                SELECT * FROM albums 
                WHERE category_id = ? AND id != ? 
                ORDER BY created_at DESC LIMIT 3
            ");
            $stmt->execute([$album['category_id'], $album['id']]);
            $related_albums = $stmt->fetchAll();
            
            if (count($related_albums) > 0):
                foreach ($related_albums as $related):
            ?>
                <div class="portfolio-item">
                    <a href="/album.php?slug=<?php echo $related['slug']; ?>">
                        <div class="portfolio-image">
                            <img src="<?php echo $related['cover_image'] ? '/uploads/' . $related['cover_image'] : '/assets/images/default-cover.jpg'; ?>" alt="<?php echo $related['title']; ?>">
                            <div class="portfolio-overlay">
                                <span>Vezi mai multe</span>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h3><?php echo $related['title']; ?></h3>
                            <span class="category"><?php echo $category ? $category['name'] : 'Diverse'; ?></span>
                        </div>
                    </a>
                </div>
            <?php 
                endforeach;
            else:
                // If no related albums in the same category, get the latest albums
                $stmt = $db->prepare("
                    SELECT * FROM albums 
                    WHERE id != ? 
                    ORDER BY created_at DESC LIMIT 3
                ");
                $stmt->execute([$album['id']]);
                $latest_albums = $stmt->fetchAll();
                
                foreach ($latest_albums as $latest):
                    $stmt = $db->prepare("SELECT name FROM categories WHERE id = ?");
                    $stmt->execute([$latest['category_id']]);
                    $cat = $stmt->fetch();
            ?>
                <div class="portfolio-item">
                    <a href="/album.php?slug=<?php echo $latest['slug']; ?>">
                        <div class="portfolio-image">
                            <img src="<?php echo $latest['cover_image'] ? '/uploads/' . $latest['cover_image'] : '/assets/images/default-cover.jpg'; ?>" alt="<?php echo $latest['title']; ?>">
                            <div class="portfolio-overlay">
                                <span>Vezi mai multe</span>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h3><?php echo $latest['title']; ?></h3>
                            <span class="category"><?php echo $cat ? $cat['name'] : 'Diverse'; ?></span>
                        </div>
                    </a>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    </div>
</section>

<!-- Light Gallery initialization -->
 <div class="photo-gallery" id="lightgallery">
    <?php foreach ($photos as $photo): ?>
        <a href="/<?php echo htmlspecialchars($photo['file_path']); ?>" class="lightbox" data-caption="<?php echo htmlspecialchars($photo['title']); ?>">
            <img src="/<?php echo htmlspecialchars($photo['file_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" loading="lazy">
        </a>
    <?php endforeach; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgThumbnail, lgZoom],
            speed: 500,
            thumbnail: true,
            zoom: true,
            selector: '.lightbox'
        });
    });
    </div>
<?php include 'includes/footer.php'; ?>