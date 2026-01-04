<?php
/**
 * Admin Dashboard Homepage
 */
$page_title = 'Dashboard';
include 'includes/header.php';

// Get statistics
$conn = getDBConnection();

// Total applications
$total_apps = 0;
$pending_apps = 0;
$approved_apps = 0;
$rejected_apps = 0;

// Total messages
$total_messages = 0;
$unread_messages = 0;

// Recent applications (last 7 days)
$recent_apps = 0;
$recent_messages = 0;

if ($conn) {
    // Application statistics
    $result = $conn->query("SELECT COUNT(*) as total FROM loan_applications");
    if ($result) {
        $total_apps = $result->fetch_assoc()['total'];
    }
    
    $result = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'pending'");
    if ($result) {
        $pending_apps = $result->fetch_assoc()['total'];
    }
    
    $result = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'approved'");
    if ($result) {
        $approved_apps = $result->fetch_assoc()['total'];
    }
    
    $result = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'rejected'");
    if ($result) {
        $rejected_apps = $result->fetch_assoc()['total'];
    }
    
    // Message statistics
    $result = $conn->query("SELECT COUNT(*) as total FROM contact_messages");
    if ($result) {
        $total_messages = $result->fetch_assoc()['total'];
    }
    
    $result = $conn->query("SELECT COUNT(*) as total FROM contact_messages WHERE status = 'unread'");
    if ($result) {
        $unread_messages = $result->fetch_assoc()['total'];
    }
    
    // Recent applications (last 7 days)
    $result = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    if ($result) {
        $recent_apps = $result->fetch_assoc()['total'];
    }
    
    // Recent messages (last 7 days)
    $result = $conn->query("SELECT COUNT(*) as total FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    if ($result) {
        $recent_messages = $result->fetch_assoc()['total'];
    }
    
    // Get recent applications
    $recent_applications_query = "SELECT * FROM loan_applications ORDER BY created_at DESC LIMIT 5";
    $recent_applications = $conn->query($recent_applications_query);
    
    // Get recent messages
    $recent_messages_query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
    $recent_messages_result = $conn->query($recent_messages_query);
    
    closeDBConnection($conn);
}
?>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="stats-card">
            <div class="icon blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3><?php echo $total_apps; ?></h3>
            <p>Total Applications</p>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stats-card">
            <div class="icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <h3><?php echo $pending_apps; ?></h3>
            <p>Pending Applications</p>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stats-card">
            <div class="icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3><?php echo $approved_apps; ?></h3>
            <p>Approved Applications</p>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="stats-card">
            <div class="icon red">
                <i class="fas fa-envelope"></i>
            </div>
            <h3><?php echo $unread_messages; ?></h3>
            <p>Unread Messages</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Applications -->
    <div class="col-md-8 mb-4">
        <div class="table-responsive">
            <h5 class="mb-3"><i class="fas fa-file-alt"></i> Recent Loan Applications</h5>
            <?php if ($recent_applications && $recent_applications->num_rows > 0): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Loan Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($app = $recent_applications->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo str_pad($app['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo htmlspecialchars(isset($app['full_names']) ? $app['full_names'] : 'N/A'); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($app['loan_type'])); ?></td>
                        <td>RWF <?php echo number_format($app['loan_amount'], 0); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $app['status']; ?>">
                                <?php echo ucfirst($app['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                        <td>
                            <a href="application_detail.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="applications.php" class="btn btn-primary">View All Applications</a>
            </div>
            <?php else: ?>
            <p class="text-muted">No applications found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Messages -->
    <div class="col-md-4 mb-4">
        <div class="table-responsive">
            <h5 class="mb-3"><i class="fas fa-envelope"></i> Recent Messages</h5>
            <?php if ($recent_messages_result && $recent_messages_result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($msg = $recent_messages_result->fetch_assoc()): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?php echo htmlspecialchars($msg['name']); ?></h6>
                            <p class="mb-1 small text-muted"><?php echo htmlspecialchars(substr($msg['subject'], 0, 50)); ?>...</p>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></small>
                        </div>
                        <span class="badge badge-<?php echo $msg['status'] == 'unread' ? 'unread' : 'read'; ?> ml-2">
                            <?php echo $msg['status'] == 'unread' ? 'New' : 'Read'; ?>
                        </span>
                    </div>
                    <a href="message_detail.php?id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="text-center mt-3">
                <a href="messages.php" class="btn btn-primary">View All Messages</a>
            </div>
            <?php else: ?>
            <p class="text-muted">No messages found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>







