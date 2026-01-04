<?php
/**
 * Process Contact Form
 * Easy Funds 4 You
 */

// Start output buffering to prevent any output before headers
ob_start();
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: contact.php');
    exit;
}

// Get and sanitize form data
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Validation
$errors = [];
if (empty($name)) $errors[] = 'Name is required';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
if (empty($subject)) $errors[] = 'Subject is required';
if (empty($message)) $errors[] = 'Message is required';

if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    $_SESSION['contact_data'] = $_POST;
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: contact.php');
    exit;
}

// Include database configuration
require_once 'config/database.php';

$conn = getDBConnection();

if ($conn) {
    // Create contact_messages table if it doesn't exist
    $create_table = "CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status VARCHAR(20) DEFAULT 'unread',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->query($create_table);
    
    // Insert message
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
    if ($stmt->execute()) {
        $message_id = $conn->insert_id;
        $stmt->close();
        
        // Send email notification to admin
        $admin_email = 'info@easyfunds4you.rw'; // Change this to your admin email
        $email_subject = "New Contact Message: " . $subject;
        $email_message = "You have received a new contact message from your website.\n\n";
        $email_message .= "Name: " . $name . "\n";
        $email_message .= "Email: " . $email . "\n";
        $email_message .= "Subject: " . $subject . "\n\n";
        $email_message .= "Message:\n" . $message . "\n\n";
        $email_message .= "---\n";
        $email_message .= "View this message in admin panel: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/admin/message_detail.php?id=" . $message_id;
        
        $headers = "From: Easy Funds 4 You <noreply@easyfunds4you.rw>\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        @mail($admin_email, $email_subject, $email_message, $headers);
        
        closeDBConnection($conn);
        $_SESSION['contact_success'] = true;
        ob_end_clean(); // Clean output buffer before redirect
        header('Location: contact.php');
        exit;
    } else {
        $errors[] = 'Failed to send message. Please try again.';
        $_SESSION['contact_errors'] = $errors;
        $_SESSION['contact_data'] = $_POST;
        $stmt->close();
        closeDBConnection($conn);
        ob_end_clean(); // Clean output buffer before redirect
        header('Location: contact.php');
        exit;
    }
} else {
    $_SESSION['contact_errors'] = ['Unable to process your message. Please contact us directly at +250796693784 or info@easyfunds4you.rw'];
    $_SESSION['contact_data'] = $_POST;
    ob_end_clean(); // Clean output buffer before redirect
    header('Location: contact.php');
    exit;
}

