<?php
/**
 * Loan Applications Management
 */
$page_title = 'Loan Applications';
include 'includes/header.php';

$conn = getDBConnection();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $application_id = intval($_POST['application_id']);
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE loan_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $application_id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Application status updated successfully!
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
$query = "SELECT * FROM loan_applications WHERE 1=1";
$params = [];
$types = '';

if ($status_filter) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

if ($search) {
    $query .= " AND (full_names LIKE ? OR email LIKE ? OR telephone LIKE ? OR national_id LIKE ?)";
    $search_term = "%$search%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= 'ssss';
}

$query .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$applications = $stmt->get_result();

// Get counts
$total_count = $conn->query("SELECT COUNT(*) as total FROM loan_applications")->fetch_assoc()['total'];
$pending_count = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'pending'")->fetch_assoc()['total'];
$approved_count = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'approved'")->fetch_assoc()['total'];
$rejected_count = $conn->query("SELECT COUNT(*) as total FROM loan_applications WHERE status = 'rejected'")->fetch_assoc()['total'];
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-file-alt"></i> Loan Applications</h4>
            
            <!-- Filter Form -->
            <form method="GET" class="form-inline">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search by name, email, phone, ID..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="status" class="form-control mr-2">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo $status_filter == 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo $status_filter == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                <?php if ($status_filter || $search): ?>
                <a href="applications.php" class="btn btn-secondary ml-2">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card text-center">
            <h3><?php echo $total_count; ?></h3>
            <p>Total Applications</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <h3 class="text-warning"><?php echo $pending_count; ?></h3>
            <p>Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <h3 class="text-success"><?php echo $approved_count; ?></h3>
            <p>Approved</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <h3 class="text-danger"><?php echo $rejected_count; ?></h3>
            <p>Rejected</p>
        </div>
    </div>
</div>

<!-- Applications Table -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Loan Type</th>
                <th>Amount</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($applications->num_rows > 0): ?>
                <?php while ($app = $applications->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo str_pad($app['id'], 6, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars(isset($app['full_names']) ? $app['full_names'] : 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars(isset($app['email']) && !empty($app['email']) ? $app['email'] : 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars(isset($app['telephone']) ? $app['telephone'] : 'N/A'); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($app['loan_type'])); ?></td>
                    <td>RWF <?php echo number_format($app['loan_amount'], 0); ?></td>
                    <td>
                        <?php 
                        $duration_map = ['1' => '1 Month', '2' => '2 Months', '3' => '3 Months'];
                        $duration = isset($app['loan_duration_months']) ? $app['loan_duration_months'] : '';
                        echo isset($duration_map[$duration]) ? $duration_map[$duration] : ($duration ? $duration : 'N/A');
                        ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo $app['status']; ?>">
                            <?php echo ucfirst($app['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                    <td>
                        <a href="application_detail.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center text-muted">No applications found.</td>
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







