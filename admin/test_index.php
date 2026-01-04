<?php
/**
 * Test index.php loading
 * DELETE THIS FILE AFTER TESTING!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Admin Index Loading</h2>";

echo "<h3>Step 1: Testing config files</h3>";

$root_path = dirname(dirname(__DIR__));
$db_path = $root_path . '/config/database.php';
$admin_config_path = dirname(__DIR__) . '/config.php';

echo "Loading database.php...<br>";
if (file_exists($db_path)) {
    require_once $db_path;
    echo "✓ database.php loaded<br>";
} else {
    die("✗ database.php NOT FOUND");
}

echo "Loading config.php...<br>";
if (file_exists($admin_config_path)) {
    require_once $admin_config_path;
    echo "✓ config.php loaded<br>";
} else {
    die("✗ config.php NOT FOUND");
}

echo "<h3>Step 2: Testing session</h3>";
echo "Session status: " . session_status() . "<br>";
if (isset($_SESSION)) {
    echo "Session array: <pre>" . print_r($_SESSION, true) . "</pre>";
}

echo "<h3>Step 3: Testing isAdminLoggedIn()</h3>";
if (function_exists('isAdminLoggedIn')) {
    $logged_in = isAdminLoggedIn();
    echo "isAdminLoggedIn() result: " . ($logged_in ? 'true' : 'false') . "<br>";
} else {
    echo "✗ isAdminLoggedIn() function not found<br>";
}

echo "<h3>Step 4: Testing requireAdminLogin()</h3>";
if (function_exists('requireAdminLogin')) {
    echo "requireAdminLogin() function exists<br>";
    echo "NOTE: This will redirect if not logged in, so we won't call it here<br>";
} else {
    echo "✗ requireAdminLogin() function not found<br>";
}

echo "<h3>Step 5: Testing getDBConnection()</h3>";
if (function_exists('getDBConnection')) {
    $conn = getDBConnection();
    if ($conn) {
        echo "✓ Database connection successful<br>";
        closeDBConnection($conn);
    } else {
        echo "✗ Database connection failed<br>";
    }
} else {
    echo "✗ getDBConnection() function not found<br>";
}

echo "<h3>Step 6: Testing header.php inclusion (simulated)</h3>";
$header_path = __DIR__ . '/includes/header.php';
if (file_exists($header_path)) {
    echo "✓ header.php exists at: $header_path<br>";
    echo "Attempting to read first 20 lines...<br>";
    $lines = file($header_path);
    echo "<pre>";
    for ($i = 0; $i < min(20, count($lines)); $i++) {
        echo ($i + 1) . ": " . htmlspecialchars($lines[$i]);
    }
    echo "</pre>";
} else {
    echo "✗ header.php NOT FOUND<br>";
}

