<?php
/**
 * Process Loan Application
 * Easy Funds 4 You
 */

// Start output buffering to prevent any output before headers
ob_start();
// Start session for storing messages
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: apply.php');
    exit;
}

// Include database configuration
require_once 'config/database.php';

// Helper function to sanitize strings
function sanitize_string($value) {
    return isset($value) && is_string($value) ? htmlspecialchars(trim($value)) : '';
}

// Helper function to sanitize array
function sanitize_array($value) {
    if (!isset($value) || !is_array($value)) {
        return [];
    }
    return array_map('htmlspecialchars', array_map('trim', $value));
}

// Get form data and sanitize
// SECTION 1: PERSONAL INFORMATION
$full_names = sanitize_string($_POST['full_names'] ?? '');
$national_id = sanitize_string($_POST['national_id'] ?? '');
$telephone = sanitize_string($_POST['telephone'] ?? '');
$email = isset($_POST['email']) && !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$residential_address = sanitize_string($_POST['residential_address'] ?? '');

// SECTION 2: EMPLOYMENT INFORMATION
$employment_category = sanitize_string($_POST['employment_category'] ?? '');

// Employment category specific fields
$employer_name = sanitize_string($_POST['employer_name'] ?? '');
$job_title = sanitize_string($_POST['job_title'] ?? '');
$net_monthly_salary = isset($_POST['net_monthly_salary']) ? floatval($_POST['net_monthly_salary']) : 0;

$activity_nature = sanitize_string($_POST['activity_nature'] ?? '');
$business_location = sanitize_string($_POST['business_location'] ?? '');
$years_operation = isset($_POST['years_operation']) ? intval($_POST['years_operation']) : 0;
$avg_monthly_income = isset($_POST['avg_monthly_income']) ? floatval($_POST['avg_monthly_income']) : 0;

$business_name = sanitize_string($_POST['business_name'] ?? '');
$business_type = sanitize_string($_POST['business_type'] ?? '');
$business_years = isset($_POST['business_years']) ? intval($_POST['business_years']) : 0;
$business_monthly_income = isset($_POST['business_monthly_income']) ? floatval($_POST['business_monthly_income']) : 0;

$income_description = sanitize_string($_POST['income_description'] ?? '');
$income_frequency = sanitize_string($_POST['income_frequency'] ?? '');
$estimated_monthly_income = isset($_POST['estimated_monthly_income']) ? floatval($_POST['estimated_monthly_income']) : 0;

// SECTION 3: LOAN INFORMATION
$loan_type_array = sanitize_array($_POST['loan_type'] ?? []);
$loan_type = !empty($loan_type_array) ? implode(', ', $loan_type_array) : '';
$loan_amount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0;
$loan_duration_months = sanitize_string($_POST['loan_duration_months'] ?? '');
$loan_purpose = sanitize_string($_POST['loan_purpose'] ?? '');

// SECTION 4: COLLATERAL INFORMATION
$collateral_type_array = sanitize_array($_POST['collateral_type'] ?? []);
$collateral_type = !empty($collateral_type_array) ? implode(', ', $collateral_type_array) : '';

// SECTION 5: GUARANTOR INFORMATION
$guarantor1_name = sanitize_string($_POST['guarantor1_name'] ?? '');
$guarantor1_phone = sanitize_string($_POST['guarantor1_phone'] ?? '');
$guarantor1_relationship = sanitize_string($_POST['guarantor1_relationship'] ?? '');

$guarantor2_name = sanitize_string($_POST['guarantor2_name'] ?? '');
$guarantor2_phone = sanitize_string($_POST['guarantor2_phone'] ?? '');
$guarantor2_relationship = sanitize_string($_POST['guarantor2_relationship'] ?? '');

$guarantor3_name = sanitize_string($_POST['guarantor3_name'] ?? '');
$guarantor3_phone = sanitize_string($_POST['guarantor3_phone'] ?? '');
$guarantor3_relationship = sanitize_string($_POST['guarantor3_relationship'] ?? '');

// DECLARATION
$declaration_agree = isset($_POST['declaration_agree']) ? true : false;

// Basic validation
$errors = [];

if (empty($full_names)) $errors[] = 'Full names is required';
if (empty($national_id)) $errors[] = 'National ID / Passport Number is required';
if (empty($telephone)) $errors[] = 'Telephone number is required';
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email address is required';
if (empty($residential_address)) $errors[] = 'Residential address is required';

if (empty($employment_category)) $errors[] = 'Employment category is required';

// Validate employment category specific fields
if ($employment_category === 'employed') {
    if (empty($employer_name)) $errors[] = 'Employer / Institution Name is required';
    if (empty($job_title)) $errors[] = 'Job Title / Position is required';
    if ($net_monthly_salary <= 0) $errors[] = 'Net Monthly Salary is required';
} elseif ($employment_category === 'self_employed') {
    if (empty($activity_nature)) $errors[] = 'Nature of Activity / Service is required';
    if (empty($business_location)) $errors[] = 'Business Location is required';
    if ($years_operation < 0) $errors[] = 'Years of Operation is required';
    if ($avg_monthly_income <= 0) $errors[] = 'Average Monthly Income is required';
} elseif ($employment_category === 'business_owner') {
    if (empty($business_name)) $errors[] = 'Business Name is required';
    if (empty($business_type)) $errors[] = 'Type of Business / Sector is required';
    if ($business_years < 0) $errors[] = 'Years in Operation is required';
    if ($business_monthly_income <= 0) $errors[] = 'Average Monthly Business Income is required';
} elseif ($employment_category === 'other') {
    if (empty($income_description)) $errors[] = 'Description of Income Source is required';
    if (empty($income_frequency)) $errors[] = 'Income Frequency is required';
    if ($estimated_monthly_income <= 0) $errors[] = 'Estimated Average Monthly Income is required';
}

if (empty($loan_type_array)) $errors[] = 'At least one type of loan requested is required';
if ($loan_amount <= 0) $errors[] = 'Valid loan amount is required';
if (empty($loan_duration_months)) $errors[] = 'Loan duration is required';
if (empty($loan_purpose)) $errors[] = 'Purpose of the loan is required';

if (empty($collateral_type_array)) $errors[] = 'At least one type of collateral is required';

// Validate guarantors if guarantor is selected as collateral
if (in_array('guarantor', $collateral_type_array)) {
    if (empty($guarantor1_name)) $errors[] = 'Guarantor 1 Full Name is required';
    if (empty($guarantor1_phone)) $errors[] = 'Guarantor 1 Telephone Number is required';
    if (empty($guarantor1_relationship)) $errors[] = 'Guarantor 1 Relationship is required';
}

if (!$declaration_agree) $errors[] = 'You must agree to the declaration and consent';

// If there are errors, redirect back to form
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: apply.php');
    exit;
}

// Connect to database
$conn = getDBConnection();

if ($conn) {
    // Create applications table if it doesn't exist (updated schema)
    $create_table = "CREATE TABLE IF NOT EXISTS loan_applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_names VARCHAR(255) NOT NULL,
        national_id VARCHAR(100) NOT NULL,
        telephone VARCHAR(50) NOT NULL,
        email VARCHAR(255),
        residential_address TEXT NOT NULL,
        employment_category VARCHAR(50) NOT NULL,
        employer_name VARCHAR(255),
        job_title VARCHAR(255),
        net_monthly_salary DECIMAL(15,2),
        activity_nature VARCHAR(255),
        business_location VARCHAR(255),
        years_operation INT,
        avg_monthly_income DECIMAL(15,2),
        business_name VARCHAR(255),
        business_type VARCHAR(255),
        business_years INT,
        business_monthly_income DECIMAL(15,2),
        income_description TEXT,
        income_frequency VARCHAR(50),
        estimated_monthly_income DECIMAL(15,2),
        loan_type TEXT NOT NULL,
        loan_amount DECIMAL(15,2) NOT NULL,
        loan_duration_months VARCHAR(10) NOT NULL,
        loan_purpose TEXT NOT NULL,
        collateral_type TEXT NOT NULL,
        guarantor1_name VARCHAR(255),
        guarantor1_phone VARCHAR(50),
        guarantor1_relationship VARCHAR(50),
        guarantor2_name VARCHAR(255),
        guarantor2_phone VARCHAR(50),
        guarantor2_relationship VARCHAR(50),
        guarantor3_name VARCHAR(255),
        guarantor3_phone VARCHAR(50),
        guarantor3_relationship VARCHAR(50),
        status VARCHAR(20) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->query($create_table);
    
    // Insert application
    $stmt = $conn->prepare("INSERT INTO loan_applications 
        (full_names, national_id, telephone, email, residential_address, 
         employment_category, employer_name, job_title, net_monthly_salary,
         activity_nature, business_location, years_operation, avg_monthly_income,
         business_name, business_type, business_years, business_monthly_income,
         income_description, income_frequency, estimated_monthly_income,
         loan_type, loan_amount, loan_duration_months, loan_purpose, collateral_type,
         guarantor1_name, guarantor1_phone, guarantor1_relationship,
         guarantor2_name, guarantor2_phone, guarantor2_relationship,
         guarantor3_name, guarantor3_phone, guarantor3_relationship) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Build type string: 34 parameters total
    // Type mapping: s=string, d=double/float, i=integer
    // 1-8: s, 9: d, 10-11: s, 12: i, 13: d, 14-15: s, 16: i, 17: d, 18-19: s, 20: d, 21: s, 22: d, 23-25: s, 26-34: s
    $type_string = "ssssssss" . "d" . "ss" . "i" . "d" . "ss" . "i" . "d" . "ss" . "d" . "s" . "d" . "sss" . "sssssssss";
    
    $stmt->bind_param($type_string,
        $full_names, $national_id, $telephone, $email, $residential_address,
        $employment_category, $employer_name, $job_title, $net_monthly_salary,
        $activity_nature, $business_location, $years_operation, $avg_monthly_income,
        $business_name, $business_type, $business_years, $business_monthly_income,
        $income_description, $income_frequency, $estimated_monthly_income,
        $loan_type, $loan_amount, $loan_duration_months, $loan_purpose, $collateral_type,
        $guarantor1_name, $guarantor1_phone, $guarantor1_relationship,
        $guarantor2_name, $guarantor2_phone, $guarantor2_relationship,
        $guarantor3_name, $guarantor3_phone, $guarantor3_relationship);
    
    if ($stmt->execute()) {
        $application_id = $conn->insert_id;
        $stmt->close();
        closeDBConnection($conn);
        
        // Success - redirect to thank you page
        $_SESSION['success'] = true;
        $_SESSION['application_id'] = $application_id;
        ob_end_clean(); // Clean output buffer before redirect
        header('Location: application_success.php');
        exit;
    } else {
        $errors[] = 'Failed to submit application. Please try again.';
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        $stmt->close();
        closeDBConnection($conn);
        ob_end_clean(); // Clean output buffer before redirect
        header('Location: apply.php');
        exit;
    }
} else {
    // Database connection failed
    $_SESSION['errors'] = ['Database connection failed. Please contact us directly at +250796693784 or info@easyfunds4you.rw'];
    $_SESSION['form_data'] = $_POST;
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: apply.php');
    exit;
}
