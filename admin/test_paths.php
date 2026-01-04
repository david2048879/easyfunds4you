<?php
/**
 * Temporary diagnostic file to test paths
 * DELETE THIS FILE AFTER TESTING!
 */

echo "<h2>Path Diagnostic Test</h2>";

echo "<h3>Current directory info:</h3>";
echo "__DIR__: " . __DIR__ . "<br>";
echo "Script location: " . __FILE__ . "<br>";

echo "<h3>Testing config paths (from admin/ directory):</h3>";

// Test database.php path - from admin/ directory
$root_path = dirname(__DIR__); // Should be public_html
$db_path = $root_path . '/config/database.php';
echo "Root path: " . $root_path . "<br>";
echo "Database config path: " . $db_path . "<br>";
echo "Real path: " . realpath($db_path) . "<br>";
if (file_exists($db_path)) {
    echo "✓ database.php exists<br>";
    require_once $db_path;
    echo "✓ database.php loaded successfully<br>";
} else {
    echo "✗ database.php NOT FOUND at: " . $db_path . "<br>";
}

// Test admin config.php path
$admin_config_path = __DIR__ . '/config.php';
echo "<br>Admin config path: " . $admin_config_path . "<br>";
echo "Real path: " . realpath($admin_config_path) . "<br>";
if (file_exists($admin_config_path)) {
    echo "✓ config.php exists<br>";
    require_once $admin_config_path;
    echo "✓ config.php loaded successfully<br>";
} else {
    echo "✗ config.php NOT FOUND at: " . $admin_config_path . "<br>";
}

echo "<h3>Testing paths from admin/includes/ (like header.php):</h3>";
$includes_dir = __DIR__ . '/includes';
if (is_dir($includes_dir)) {
    $root_from_includes = dirname(dirname($includes_dir));
    $db_path_from_includes = $root_from_includes . '/config/database.php';
    echo "Root from includes: " . $root_from_includes . "<br>";
    echo "Database path from includes: " . $db_path_from_includes . "<br>";
    echo "Real path: " . realpath($db_path_from_includes) . "<br>";
    if (file_exists($db_path_from_includes)) {
        echo "✓ database.php exists from includes directory<br>";
    } else {
        echo "✗ database.php NOT FOUND from includes directory<br>";
    }
    
    $admin_config_from_includes = dirname($includes_dir) . '/config.php';
    echo "Admin config from includes: " . $admin_config_from_includes . "<br>";
    echo "Real path: " . realpath($admin_config_from_includes) . "<br>";
    if (file_exists($admin_config_from_includes)) {
        echo "✓ config.php exists from includes directory<br>";
    } else {
        echo "✗ config.php NOT FOUND from includes directory<br>";
    }
}

echo "<h3>Directory structure check:</h3>";
$base_dir = dirname(dirname(__DIR__));
echo "Base directory (project root): " . $base_dir . "<br>";
echo "Contents of base directory:<br>";
if (is_dir($base_dir)) {
    $items = scandir($base_dir);
    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            echo "- " . $item . "<br>";
        }
    }
}

echo "<h3>PHP Error Reporting:</h3>";
echo "Error reporting level: " . error_reporting() . "<br>";
echo "Display errors: " . ini_get('display_errors') . "<br>";

