<?php
// header.php is in admin/includes/, so we need to go up to root for config/database.php
// Use dirname() twice to go up from admin/includes/ to public_html/
$root_path = dirname(dirname(__DIR__));
require_once $root_path . '/config/database.php';
// admin/config.php is one level up from includes
require_once dirname(__DIR__) . '/config.php';
requireAdminLogin();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Dashboard'; ?> - Easy Funds 4 You</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #409645;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        
        body {
            font-family: 'Rubik', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding-top: var(--header-height);
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar .logo img {
            max-width: 120px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin: 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu a i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
        }
        
        /* Header */
        .admin-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }
        
        .admin-header h4 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }
        
        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-header .user-info span {
            color: #666;
        }
        
        .admin-header .btn-logout {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .admin-header .btn-logout:hover {
            background: #357a3a;
            color: white;
        }
        
        /* Content Area */
        .content-wrapper {
            padding: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }
        
        .stats-card .icon.blue { background: #3498db; }
        .stats-card .icon.green { background: var(--primary-color); }
        .stats-card .icon.orange { background: #f39c12; }
        .stats-card .icon.red { background: #e74c3c; }
        
        .stats-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: #333;
        }
        
        .stats-card p {
            color: #666;
            margin: 5px 0 0 0;
        }
        
        .table-responsive {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .badge-pending { background: #f39c12; color: white; }
        .badge-approved { background: #27ae60; color: white; }
        .badge-rejected { background: #e74c3c; color: white; }
        .badge-unread { background: #3498db; color: white; }
        .badge-read { background: #95a5a6; color: white; }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .admin-header {
                left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../assets/img/logo/EasyFunds4You_logo.png" alt="Easy Funds 4 You">
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a></li>
            <li><a href="applications.php" class="<?php echo $current_page == 'applications.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Loan Applications
            </a></li>
            <li><a href="messages.php" class="<?php echo $current_page == 'messages.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Contact Messages
            </a></li>
            <li><a href="news.php" class="<?php echo in_array($current_page, ['news.php', 'add_news.php', 'edit_news.php']) ? 'active' : ''; ?>">
                <i class="fas fa-newspaper"></i> News Management
            </a></li>
            <li><a href="../index.php" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Website
            </a></li>
            <li><a href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="admin-header">
            <h4><?php echo isset($page_title) ? $page_title : 'Admin Dashboard'; ?></h4>
            <div class="user-info">
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">



