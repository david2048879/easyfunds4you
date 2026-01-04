<?php
/**
 * Edit News
 */
// Include database connection
require_once '../config/database.php';

$errors = [];
$news = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: news.php');
    exit();
}

$id = intval($_GET['id']);

// Get news item
$conn = getDBConnection();
if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
    $stmt->close();
    
    if (!$news) {
        closeDBConnection($conn);
        header('Location: news.php');
        exit();
    }
    
    closeDBConnection($conn);
} else {
    header('Location: news.php');
    exit();
}

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
                
                // Delete old image if it exists and is in the news folder
                if (!empty($news['image']) && strpos($news['image'], 'assets/img/news/') === 0 && file_exists('../' . $news['image'])) {
                    @unlink('../' . $news['image']);
                }
            } else {
                $errors[] = 'Failed to upload image. Please try again.';
            }
        } else {
            $errors[] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF, WEBP';
        }
    }
    
    // Use uploaded image or image URL, or keep existing image if neither is provided
    $image = !empty($uploaded_image) ? $uploaded_image : (!empty($image_url) ? $image_url : $news['image']);
    
    if (empty($errors)) {
        $conn = getDBConnection();
        if ($conn) {
            $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, excerpt = ?, image = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $title, $content, $excerpt, $image, $status, $id);
            
            if ($stmt->execute()) {
                $stmt->close();
                closeDBConnection($conn);
                // Redirect before any output
                header('Location: news.php?updated=1');
                exit();
            } else {
                $errors[] = 'Failed to update news. Please try again.';
            }
            $stmt->close();
            closeDBConnection($conn);
        } else {
            $errors[] = 'Database connection failed.';
        }
    }
}

// Include header AFTER processing POST (to allow redirects)
$page_title = 'Edit News';
include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2><i class="fas fa-edit"></i> Edit News</h2>
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

<form method="POST" action="edit_news.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="title">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required 
                       value="<?php echo htmlspecialchars($news['title']); ?>">
            </div>
            
            <div class="form-group">
                <label for="excerpt">Excerpt (Short Description)</label>
                <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($news['excerpt']); ?></textarea>
                <small class="form-text text-muted">This will be displayed on the news listing page.</small>
            </div>
            
            <div class="form-group">
                <label for="content">Content <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($news['content']); ?></textarea>
            </div>
        </div>
        
        <div class="col-md-4">
            <?php if ($news['image']): ?>
            <div class="form-group">
                <label>Current Image</label>
                <div>
                    <img src="../<?php echo htmlspecialchars($news['image']); ?>" alt="Current Image" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #ddd; margin-bottom: 10px;">
                </div>
            </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="image">Upload New Image</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                <small class="form-text text-muted">Upload a new image (JPG, PNG, GIF, WEBP) - Max size: 5MB</small>
                <div id="image-preview" class="mt-2" style="display: none;">
                    <img id="preview-img" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            </div>
            
            <div class="form-group">
                <label for="image_url">OR Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" 
                       value="<?php echo htmlspecialchars($news['image']); ?>"
                       placeholder="assets/img/gallery/home_blog1.png">
                <small class="form-text text-muted">Alternatively, enter the path to an existing image</small>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="published" <?php echo $news['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?php echo $news['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fas fa-save"></i> Update News
                </button>
                <a href="news.php" class="btn btn-secondary btn-block">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <small class="text-muted">
                        <strong>Created:</strong> <?php echo date('M d, Y H:i', strtotime($news['created_at'])); ?><br>
                        <strong>Last Updated:</strong> <?php echo date('M d, Y H:i', strtotime($news['updated_at'])); ?>
                    </small>
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

