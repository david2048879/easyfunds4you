<?php
/**
 * Database Configuration
 * Easy Funds 4 You
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'easyfunds4you');

// Create database connection
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to utf8
        $conn->set_charset("utf8");
        
        return $conn;
    } catch (Exception $e) {
        // Log error (in production, use proper logging)
        error_log("Database Connection Error: " . $e->getMessage());
        return null;
    }
}

// Close database connection
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}







