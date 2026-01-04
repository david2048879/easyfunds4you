<?php
$page_title = "News - Easy Funds 4 You";
$page_description = "Latest news and updates from Easy Funds 4 You - Financial services, loan information, and company announcements.";
include 'includes/header.php';

// Get news from database
require_once 'config/database.php';
$conn = getDBConnection();
$news_items = [];

if ($conn) {
    // Create news table if it doesn't exist
    $create_table = "CREATE TABLE IF NOT EXISTS news (
        id INT(11) NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL COMMENT 'News article title',
        content TEXT NOT NULL COMMENT 'Full news article content',
        excerpt VARCHAR(500) DEFAULT NULL COMMENT 'Short description/excerpt for listings',
        image VARCHAR(255) DEFAULT NULL COMMENT 'Path to news image (uploaded or URL)',
        author VARCHAR(100) DEFAULT 'Admin' COMMENT 'Author of the news article',
        status ENUM('published', 'draft') DEFAULT 'published' COMMENT 'Publication status',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when news was created',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date and time when news was last updated',
        PRIMARY KEY (id),
        KEY idx_status (status),
        KEY idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='News articles and blog posts'";
    $conn->query($create_table);
    
    // Get published news
    $result = $conn->query("SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $news_items[] = $row;
        }
    }
    
    closeDBConnection($conn);
}
?>

        <!-- Hero Start-->
        <div class="hero-area2 slider-height2 hero-overly2 d-flex align-items-center news-hero">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>News & Updates</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        
        <!-- News Section Start -->
        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="blog_left_sidebar">
                            <?php if (count($news_items) > 0): ?>
                                <?php foreach ($news_items as $news): ?>
                                <article class="blog_item">
                                    <?php if ($news['image']): ?>
                                    <div class="blog_item_img">
                                        <img class="card-img rounded-0" src="<?php echo htmlspecialchars($news['image']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                                        <a href="#" class="blog_item_date">
                                            <h3><?php echo date('d', strtotime($news['created_at'])); ?></h3>
                                            <p><?php echo date('M', strtotime($news['created_at'])); ?></p>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <div class="blog_details">
                                        <a class="d-inline-block" href="#">
                                            <h2><?php echo htmlspecialchars($news['title']); ?></h2>
                                        </a>
                                        <p><?php echo htmlspecialchars($news['excerpt'] ?: substr($news['content'], 0, 200)); ?>...</p>
                                        <ul class="blog-info-link">
                                            <li><a href="#"><i class="fa fa-user"></i> <?php echo htmlspecialchars($news['author']); ?></a></li>
                                            <li><a href="#"><i class="fa fa-calendar"></i> <?php echo date('F d, Y', strtotime($news['created_at'])); ?></a></li>
                                        </ul>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <p>No news articles available at the moment. Please check back later.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <!-- Search Widget -->
                            <aside class="single_sidebar_widget search_widget">
                                <form action="#">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder='Search Keyword' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'">
                                            <div class="input-group-append">
                                                <button class="btn" type="button"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Search</button>
                                </form>
                            </aside>
                            
                            <!-- Categories Widget -->
                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title">Category</h4>
                                <ul class="list cat-list">
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>Finance</p>
                                            <p>(37)</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>Loans</p>
                                            <p>(10)</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>Business</p>
                                            <p>(03)</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>Tips</p>
                                            <p>(11)</p>
                                        </a>
                                    </li>
                                </ul>
                            </aside>
                            
                            <!-- Recent Post Widget -->
                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Recent Post</h3>
                                <?php if (count($news_items) > 0): ?>
                                    <?php foreach (array_slice($news_items, 0, 3) as $recent_news): ?>
                                    <div class="media post_item">
                                        <?php if ($recent_news['image']): ?>
                                        <img src="<?php echo htmlspecialchars($recent_news['image']); ?>" alt="post" style="width: 80px; height: 60px; object-fit: cover;">
                                        <?php else: ?>
                                        <div style="width: 80px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <?php endif; ?>
                                        <div class="media-body">
                                            <a href="#">
                                                <h3><?php echo htmlspecialchars(substr($recent_news['title'], 0, 40)); ?><?php echo strlen($recent_news['title']) > 40 ? '...' : ''; ?></h3>
                                            </a>
                                            <p><?php echo date('F d, Y', strtotime($recent_news['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No recent posts</p>
                                <?php endif; ?>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- News Section End -->

<?php include 'includes/footer.php'; ?>

