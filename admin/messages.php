<?php
/**
 * Contact Messages Management
 */
$page_title = 'Contact Messages';
include 'includes/header.php';

$conn = getDBConnection();

// Handle status update (mark as read/unread)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $message_id = intval($_POST['message_id']);
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $message_id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Message status updated successfully!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    $stmt->close();
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $message_id = intval($_POST['message_id']);
    
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Message deleted successfully!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    $stmt->close();
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query
$query = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];
$types = '';

if ($status_filter) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

if ($search) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR subject LIKE ?)";
    $search_term = "%$search%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= 'sss';
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$messages = $stmt->get_result();

// Get counts
$total_count = $conn->query("SELECT COUNT(*) as total FROM contact_messages")->fetch_assoc()['total'];
$unread_count = $conn->query("SELECT COUNT(*) as total FROM contact_messages WHERE status = 'unread'")->fetch_assoc()['total'];
$read_count = $conn->query("SELECT COUNT(*) as total FROM contact_messages WHERE status = 'read'")->fetch_assoc()['total'];
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-envelope"></i> Contact Messages</h4>
            
            <!-- Filter Form -->
            <form method="GET" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search by name, email..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="status" class="form-control mr-2">
                    <option value="">All Status</option>
                    <option value="unread" <?php echo $status_filter == 'unread' ? 'selected' : ''; ?>>Unread</option>
                    <option value="read" <?php echo $status_filter == 'read' ? 'selected' : ''; ?>>Read</option>
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                <?php if ($status_filter || $search): ?>
                <a href="messages.php" class="btn btn-secondary ml-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stats-card text-center">
            <h3><?php echo $total_count; ?></h3>
            <p>Total Messages</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <h3 class="text-info"><?php echo $unread_count; ?></h3>
            <p>Unread</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <h3 class="text-secondary"><?php echo $read_count; ?></h3>
            <p>Read</p>
        </div>
    </div>
</div>

<!-- Messages Table -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($messages->num_rows > 0): ?>
                <?php while ($msg = $messages->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo str_pad($msg['id'], 6, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>"><?php echo htmlspecialchars($msg['email']); ?></a></td>
                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $msg['status']; ?>">
                            <?php echo ucfirst($msg['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <a href="message_detail.php?id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" style="display:inline;" onsubmit="return confirmDelete('Are you sure you want to delete this message?');">
                            <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                            <button type="submit" name="delete_message" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">No messages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
$stmt->close();
closeDBConnection($conn);
include 'includes/footer.php'; 
?>












