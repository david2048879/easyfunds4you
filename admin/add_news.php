<?php
/**
 * Add News
 */
// Include database connection
require_once '../config/database.php';

$errors = [];
$success = false;
$uploaded_image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $excerpt = isset($_POST['excerpt']) ? trim($_POST['excerpt']) : '';
    $image_url = isset($_POST['image_url']) ? trim($_POST['image_url']) : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'published';
    
    // Validation
    if (empty($title)) $errors[] = 'Title is required';
    if (empty($content)) $errors[] = 'Content is required';
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/img/news/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $file_name = 'news_' . time() . '_' . uniqid() . '.' . $file_extension;
            $target_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $uploaded_image = 'assets/img/news/' . $file_name;
            } else {
                $errors[] = 'Failed to upload image. Please try again.';
            }
        } else {
            $errors[] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF, WEBP';
        }
    }
    
    // Use uploaded image or image URL
    $image = !empty($uploaded_image) ? $uploaded_image : $image_url;
    
    if (empty($errors)) {
        $conn = getDBConnection();
        if ($conn) {
            // Create table if not exists
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
            
            $stmt = $conn->prepare("INSERT INTO news (title, content, excerpt, image, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $content, $excerpt, $image, $status);
            
            if ($stmt->execute()) {
                $stmt->close();
                closeDBConnection($conn);
                // Redirect before any output
                header('Location: news.php?added=1');
                exit();
            } else {
                $errors[] = 'Failed to save news. Please try again.';
            }
            $stmt->close();
            closeDBConnection($conn);
        } else {
            $errors[] = 'Database connection failed.';
        }
    }
}
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-plus-circle"></i> Add New News</h2>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="add_news.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required 
                       value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="excerpt">Excerpt (Short Description)</label>
                <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                          placeholder="Brief summary of the news (optional)"><?php echo isset($_POST['excerpt']) ? htmlspecialchars($_POST['excerpt']) : ''; ?></textarea>
                <small class="form-text text-muted">This will be displayed on the news listing page.</small>
            </div>
            
            <div class="form-group">
                <label for="content">Content <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="15" required 
                          placeholder="Write your news content here..."><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                <small class="form-text text-muted">Upload an image (JPG, PNG, GIF, WEBP) - Max size: 5MB</small>
                <div id="image-preview" class="mt-2" style="display: none;">
                    <img id="preview-img" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            </div>
            
            <div class="form-group">
                <label for="image_url">OR Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" 
                       placeholder="assets/img/gallery/home_blog1.png"
                       value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>">
                <small class="form-text text-muted">Alternatively, enter the path to an existing image</small>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="published" <?php echo (isset($_POST['status']) && $_POST['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?php echo (isset($_POST['status']) && $_POST['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fas fa-save"></i> Save News
                </button>
                <a href="news.php" class="btn btn-secondary btn-block">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6>Available Images</h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">You can use these image paths:</small>
                    <ul class="list-unstyled mt-2">
                        <li><code>assets/img/gallery/home_blog1.png</code></li>
                        <li><code>assets/img/gallery/home_blog2.png</code></li>
                        <li><code>assets/img/gallery/home_blog3.png</code></li>
                        <li><code>assets/img/gallery/home_blog4.png</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('image-preview').style.display = 'none';
    }
});
</script>

<?php include 'includes/footer.php'; ?>

