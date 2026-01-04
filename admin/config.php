<?php
/**
 * Admin Configuration
 * Easy Funds 4 You - Admin Panel
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin credentials (In production, use hashed passwords in database)
// Default credentials: admin / admin123
// CHANGE THESE IN PRODUCTION!
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123'); // In production, use password_hash()

// Check if user is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Require admin login
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        // Clean any output buffer before redirect
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Location: login.php');
        exit;
    }
}

// Logout function
function adminLogout() {
    session_unset();
    session_destroy();
    // Clean any output buffer before redirect
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Location: login.php');
    exit;
}







