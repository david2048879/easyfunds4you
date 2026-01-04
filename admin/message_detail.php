<?php
/**
 * Message Detail View
 */
$page_title = 'Message Details';
include 'includes/header.php';

$conn = getDBConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);
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
        $stmt->close();
        closeDBConnection($conn);
        header('Location: messages.php?deleted=1');
        exit;
    }
    $stmt->close();
}

// Mark as read automatically when viewed
$stmt = $conn->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ? AND status = 'unread'");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Get message details
$stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$msg = $result->fetch_assoc();

if (!$msg) {
    echo '<div class="alert alert-danger">Message not found.</div>';
    include 'includes/footer.php';
    exit;
}
?>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="messages.php" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>
    </div>
</div>

<div class="row">
    <!-- Message Details -->
    <div class="col-md-8">
        <div class="table-responsive">
            <h4 class="mb-3">Message #<?php echo str_pad($msg['id'], 6, '0', STR_PAD_LEFT); ?></h4>
            
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Message ID</th>
                    <td>#<?php echo str_pad($msg['id'], 6, '0', STR_PAD_LEFT); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-<?php echo $msg['status']; ?>">
                            <?php echo ucfirst($msg['status']); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>"><?php echo htmlspecialchars($msg['email']); ?></a></td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td><strong><?php echo htmlspecialchars($msg['subject']); ?></strong></td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                </tr>
                <tr>
                    <th>Date Received</th>
                    <td><?php echo date('F d, Y h:i A', strtotime($msg['created_at'])); ?></td>
                </tr>
            </table>
            
            <div class="mt-3">
                <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: <?php echo urlencode($msg['subject']); ?>" class="btn btn-primary">
                    <i class="fas fa-reply"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>
    
    <!-- Update Status -->
    <div class="col-md-4">
        <div class="table-responsive">
            <h5 class="mb-3">Update Status</h5>
            <form method="POST">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="unread" <?php echo $msg['status'] == 'unread' ? 'selected' : ''; ?>>Unread</option>
                        <option value="read" <?php echo $msg['status'] == 'read' ? 'selected' : ''; ?>>Read</option>
                    </select>
                </div>
                <button type="submit" name="update_status" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Update Status
                </button>
            </form>
            
            <hr>
            
            <form method="POST" onsubmit="return confirmDelete('Are you sure you want to delete this message?');">
                <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                <button type="submit" name="delete_message" class="btn btn-danger btn-block">
                    <i class="fas fa-trash"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
</div>

<?php 
$stmt->close();
closeDBConnection($conn);
include 'includes/footer.php'; 
?>

