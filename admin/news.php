<?php
/**
 * Admin News Management
 */
$page_title = 'News Management';
include 'includes/header.php';

// Include database connection
require_once '../config/database.php';

// Get all news
$conn = getDBConnection();
$news_list = [];

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
    
    // Get all news
    $result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $news_list[] = $row;
        }
    }
    
    closeDBConnection($conn);
}

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $conn = getDBConnection();
    if ($conn) {
        $id = intval($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        closeDBConnection($conn);
        header('Location: news.php?deleted=1');
        exit;
    }
}
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-newspaper"></i> News Management</h2>
            <a href="add_news.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New News
            </a>
        </div>
    </div>
</div>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    News item deleted successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if (isset($_GET['added'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    News item added successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    News item updated successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Excerpt</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($news_list) > 0): ?>
                        <?php foreach ($news_list as $news): ?>
                        <tr>
                            <td>#<?php echo $news['id']; ?></td>
                            <td>
                                <?php if ($news['image']): ?>
                                    <img src="../<?php echo htmlspecialchars($news['image']); ?>" alt="News" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($news['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($news['excerpt'] ?: $news['content'], 0, 100)); ?>...</td>
                            <td><?php echo htmlspecialchars($news['author']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $news['status'] == 'published' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($news['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($news['created_at'])); ?></td>
                            <td>
                                <a href="edit_news.php?id=<?php echo $news['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="news.php?delete=<?php echo $news['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this news item?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <p class="py-4">No news items found. <a href="add_news.php">Add your first news item</a></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

