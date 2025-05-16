<?php
$page_title = 'Portofoliu';
include 'includes/header.php';

// Get category from URL, default to 'toate'
$category_slug = isset($_GET['categorie']) ? $_GET['categorie'] : 'toate';

// Get all categories
$categories = getCategories();

// Get albums for the selected category
$albums = getAlbums($category_slug);
?>

<!-- Page Banner -->
<section class="page-banner" style="background-image: url('/assets/images/portfolio-banner.jpg')">
    <div class="container">
        <h1>Portofoliu</h1>
        <div class="breadcrumbs">
            <a href="/">Acasă</a>
            <span>&gt;</span>
            <span>Portofoliu</span>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section portfolio">
    <div class="container">
        <!-- Category Filters -->
        <div class="portfolio-filters">
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li<?php echo $category_slug == $category['slug'] ? ' class="active"' : ''; ?>>
                        <a href="?categorie=<?php echo $category['slug']; ?>"><?php echo $category['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Portfolio Grid -->
        <div class="portfolio-grid">
            <?php if (count($albums) > 0): ?>
                <?php foreach ($albums as $album): ?>
                    <div class="portfolio-item">
                        <a href="/album.php?slug=<?php echo $album['slug']; ?>">
                            <div class="portfolio-image">
                                <img src="<?php echo $album['cover_image'] ? '/uploads/' . $album['cover_image'] : '/assets/images/default-cover.jpg'; ?>" alt="<?php echo $album['title']; ?>">
                                <div class="portfolio-overlay">
                                    <span>Vezi mai multe</span>
                                </div>
                            </div>
                            <div class="portfolio-info">
                                <h3><?php echo $album['title']; ?></h3>
                                <?php 
                                // Get category name
                                $stmt = $db->prepare("SELECT name FROM categories WHERE id = ?");
                                $stmt->execute([$album['category_id']]);
                                $cat = $stmt->fetch();
                                ?>
                                <span class="category"><?php echo $cat ? $cat['name'] : 'Diverse'; ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="portfolio-empty">
                    <p>Nu există albume disponibile pentru această categorie momentan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 