<?php
/**
 * Application Detail View
 */
$page_title = 'Application Details';
include 'includes/header.php';

$conn = getDBConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE loan_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);
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

// Get application details
$stmt = $conn->prepare("SELECT * FROM loan_applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

if (!$app) {
    echo '<div class="alert alert-danger">Application not found.</div>';
    include 'includes/footer.php';
    exit;
}

// Helper function to safely get field value
function safeGet($array, $key, $default = 'N/A') {
    return isset($array[$key]) && !empty($array[$key]) ? $array[$key] : $default;
}

// Map loan duration months to text
$loan_duration_map = [
    '1' => 'ONE (1 Month)',
    '2' => 'TWO (2 Months)',
    '3' => 'THREE (3 Months)'
];
$loan_duration_text = isset($loan_duration_map[$app['loan_duration_months']]) 
    ? $loan_duration_map[$app['loan_duration_months']] 
    : safeGet($app, 'loan_duration_months');
?>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="applications.php" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Applications
        </a>
    </div>
</div>

<div class="row">
    <!-- Application Details -->
    <div class="col-md-8">
        <div class="table-responsive">
            <h4 class="mb-3">Application #<?php echo str_pad($app['id'], 6, '0', STR_PAD_LEFT); ?></h4>
            
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Application ID</th>
                    <td>#<?php echo str_pad($app['id'], 6, '0', STR_PAD_LEFT); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-<?php echo $app['status']; ?>">
                            <?php echo ucfirst($app['status']); ?>
                        </span>
                    </td>
                </tr>
                
                <!-- SECTION 1: PERSONAL INFORMATION -->
                <tr>
                    <th colspan="2" style="background-color: #f8f9fa; font-weight: bold; color: #2F855A;">
                        <i class="fas fa-user"></i> SECTION 1: PERSONAL INFORMATION
                    </th>
                </tr>
                <tr>
                    <th>Full Names</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'full_names')); ?></td>
                </tr>
                <tr>
                    <th>National ID / Passport Number</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'national_id')); ?></td>
                </tr>
                <tr>
                    <th>Telephone Number</th>
                    <td><a href="tel:<?php echo htmlspecialchars(safeGet($app, 'telephone')); ?>"><?php echo htmlspecialchars(safeGet($app, 'telephone')); ?></a></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td>
                        <?php if (!empty($app['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>"><?php echo htmlspecialchars($app['email']); ?></a>
                        <?php else: ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Residential Address</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'residential_address')); ?></td>
                </tr>
                
                <!-- SECTION 2: EMPLOYMENT INFORMATION -->
                <tr>
                    <th colspan="2" style="background-color: #f8f9fa; font-weight: bold; color: #2F855A;">
                        <i class="fas fa-briefcase"></i> SECTION 2: EMPLOYMENT INFORMATION
                    </th>
                </tr>
                <tr>
                    <th>Employment Category</th>
                    <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars(safeGet($app, 'employment_category')))); ?></td>
                </tr>
                
                <?php
                $employment_category = safeGet($app, 'employment_category', '');
                if ($employment_category === 'employed'): ?>
                    <tr>
                        <th>Employer / Institution Name</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'employer_name')); ?></td>
                    </tr>
                    <tr>
                        <th>Job Title / Position</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'job_title')); ?></td>
                    </tr>
                    <tr>
                        <th>Net Monthly Salary</th>
                        <td><strong>RWF <?php echo number_format(floatval(safeGet($app, 'net_monthly_salary', 0)), 2); ?></strong></td>
                    </tr>
                <?php elseif ($employment_category === 'self_employed'): ?>
                    <tr>
                        <th>Nature of Activity / Service</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'activity_nature')); ?></td>
                    </tr>
                    <tr>
                        <th>Business Location</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'business_location')); ?></td>
                    </tr>
                    <tr>
                        <th>Years of Operation</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'years_operation')); ?></td>
                    </tr>
                    <tr>
                        <th>Average Monthly Income</th>
                        <td><strong>RWF <?php echo number_format(floatval(safeGet($app, 'avg_monthly_income', 0)), 2); ?></strong></td>
                    </tr>
                <?php elseif ($employment_category === 'business_owner'): ?>
                    <tr>
                        <th>Business Name</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'business_name')); ?></td>
                    </tr>
                    <tr>
                        <th>Type of Business / Sector</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'business_type')); ?></td>
                    </tr>
                    <tr>
                        <th>Years in Operation</th>
                        <td><?php echo htmlspecialchars(safeGet($app, 'business_years')); ?></td>
                    </tr>
                    <tr>
                        <th>Average Monthly Business Income</th>
                        <td><strong>RWF <?php echo number_format(floatval(safeGet($app, 'business_monthly_income', 0)), 2); ?></strong></td>
                    </tr>
                <?php elseif ($employment_category === 'other'): ?>
                    <tr>
                        <th>Description of Income Source</th>
                        <td><?php echo nl2br(htmlspecialchars(safeGet($app, 'income_description'))); ?></td>
                    </tr>
                    <tr>
                        <th>Income Frequency</th>
                        <td><?php echo ucfirst(htmlspecialchars(safeGet($app, 'income_frequency'))); ?></td>
                    </tr>
                    <tr>
                        <th>Estimated Average Monthly Income</th>
                        <td><strong>RWF <?php echo number_format(floatval(safeGet($app, 'estimated_monthly_income', 0)), 2); ?></strong></td>
                    </tr>
                <?php endif; ?>
                
                <!-- SECTION 3: LOAN INFORMATION -->
                <tr>
                    <th colspan="2" style="background-color: #f8f9fa; font-weight: bold; color: #2F855A;">
                        <i class="fas fa-file-invoice-dollar"></i> SECTION 3: LOAN INFORMATION
                    </th>
                </tr>
                <tr>
                    <th>Type of Loan Requested</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'loan_type')); ?></td>
                </tr>
                <tr>
                    <th>Loan Amount Requested</th>
                    <td><strong>RWF <?php echo number_format($app['loan_amount'], 2); ?></strong></td>
                </tr>
                <tr>
                    <th>Loan Duration</th>
                    <td><?php echo htmlspecialchars($loan_duration_text); ?></td>
                </tr>
                <tr>
                    <th>Purpose of the Loan</th>
                    <td><?php echo nl2br(htmlspecialchars(safeGet($app, 'loan_purpose'))); ?></td>
                </tr>
                
                <!-- SECTION 4: COLLATERAL INFORMATION -->
                <tr>
                    <th colspan="2" style="background-color: #f8f9fa; font-weight: bold; color: #2F855A;">
                        <i class="fas fa-shield-alt"></i> SECTION 4: COLLATERAL INFORMATION
                    </th>
                </tr>
                <tr>
                    <th>Type of Collateral Provided</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'collateral_type')); ?></td>
                </tr>
                
                <!-- SECTION 5: GUARANTOR INFORMATION -->
                <?php if (!empty($app['guarantor1_name']) || !empty($app['guarantor2_name']) || !empty($app['guarantor3_name'])): ?>
                <tr>
                    <th colspan="2" style="background-color: #f8f9fa; font-weight: bold; color: #2F855A;">
                        <i class="fas fa-users"></i> SECTION 5: GUARANTOR INFORMATION
                    </th>
                </tr>
                <?php if (!empty($app['guarantor1_name'])): ?>
                <tr>
                    <th>Guarantor 1 - Name</th>
                    <td><?php echo htmlspecialchars($app['guarantor1_name']); ?></td>
                </tr>
                <tr>
                    <th>Guarantor 1 - Phone</th>
                    <td><a href="tel:<?php echo htmlspecialchars($app['guarantor1_phone']); ?>"><?php echo htmlspecialchars(safeGet($app, 'guarantor1_phone')); ?></a></td>
                </tr>
                <tr>
                    <th>Guarantor 1 - Relationship</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'guarantor1_relationship')); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if (!empty($app['guarantor2_name'])): ?>
                <tr>
                    <th>Guarantor 2 - Name</th>
                    <td><?php echo htmlspecialchars($app['guarantor2_name']); ?></td>
                </tr>
                <tr>
                    <th>Guarantor 2 - Phone</th>
                    <td><a href="tel:<?php echo htmlspecialchars($app['guarantor2_phone']); ?>"><?php echo htmlspecialchars(safeGet($app, 'guarantor2_phone')); ?></a></td>
                </tr>
                <tr>
                    <th>Guarantor 2 - Relationship</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'guarantor2_relationship')); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if (!empty($app['guarantor3_name'])): ?>
                <tr>
                    <th>Guarantor 3 - Name</th>
                    <td><?php echo htmlspecialchars($app['guarantor3_name']); ?></td>
                </tr>
                <tr>
                    <th>Guarantor 3 - Phone</th>
                    <td><a href="tel:<?php echo htmlspecialchars($app['guarantor3_phone']); ?>"><?php echo htmlspecialchars(safeGet($app, 'guarantor3_phone')); ?></a></td>
                </tr>
                <tr>
                    <th>Guarantor 3 - Relationship</th>
                    <td><?php echo htmlspecialchars(safeGet($app, 'guarantor3_relationship')); ?></td>
                </tr>
                <?php endif; ?>
                <?php endif; ?>
                
                <tr>
                    <th>Application Date</th>
                    <td><?php echo date('F d, Y h:i A', strtotime($app['created_at'])); ?></td>
                </tr>
            </table>
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
                        <option value="pending" <?php echo $app['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo $app['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $app['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                <button type="submit" name="update_status" class="btn btn-primary btn-block">
                    <i class="fas fa-save"></i> Update Status
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
