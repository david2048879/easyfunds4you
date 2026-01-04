<?php
// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html class="no-js" lang="zxx">
    
<head>
    <script>
    (function(w,i,g){w[g]=w[g]||[];if(typeof w[g].push=='function')w[g].push(i)})
    (window,'G-SEKJ4E9T4H','google_tags_first_party');
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('set', 'developer_id.dYzg1YT', true);
        gtag('config', 'G-SEKJ4E9T4H');
    </script>
			
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo isset($page_title) ? $page_title : 'Easy Funds 4 You'; ?></title>
        <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Fast, secure, and reliable collateral-based short-term loans in Kigali, Rwanda'; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.html">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		<!-- CSS here -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
            <link rel="stylesheet" href="assets/css/slicknav.css">
            <link rel="stylesheet" href="assets/css/flaticon.css">
            <link rel="stylesheet" href="assets/css/animate.min.css">
            <link rel="stylesheet" href="assets/css/magnific-popup.css">
            <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="assets/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/slick.css">
            <link rel="stylesheet" href="assets/css/nice-select.css">
            <link rel="stylesheet" href="assets/css/style.css">
            <link rel="stylesheet" href="assets/css/responsive.css">
            <link rel="stylesheet" href="assets/css/custom-footer.css">
            <link rel="stylesheet" href="assets/css/green-theme.css">
            <link rel="stylesheet" href="assets/css/loan-products.css">
            <link rel="stylesheet" href="assets/css/why-choose.css">
            <link rel="stylesheet" href="assets/css/about-page.css">
            <link rel="stylesheet" href="assets/css/hero-new.css">
            <link rel="stylesheet" href="assets/css/news-section.css">
            <link rel="stylesheet" href="assets/css/faqs-section.css">
            <?php if ($current_page == 'contact.php'): ?>
            <link rel="stylesheet" href="assets/css/contact-form.css">
            <?php endif; ?>
            <?php if ($current_page == 'apply.php'): ?>
            <link rel="stylesheet" href="assets/css/application-form.css">
            <?php endif; ?>
            <link rel="stylesheet" href="assets/css/page-hero.css">
            <link rel="stylesheet" href="assets/css/whatsapp-button.css">
   </head>

   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/EasyFunds4You_logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
                <div class="main-header  header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2 col-md-1">
                                <div class="logo">
                                    <a href="index.php"><img style="display: inline-block; width: 100px;" src="assets/img/logo/EasyFunds4You_logo.png" alt="Easy Funds 4 You"></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav> 
                                        <ul id="navigation">  
                                            <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                                            <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>"><a href="about.php">About</a></li>
                                            <li class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>"><a href="services.php">Services</a></li>
                                            <li class="<?php echo ($current_page == 'news.php') ? 'active' : ''; ?>"><a href="news.php">News</a></li>
                                            <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block">
                                    <a href="apply.php" class="btn header-btn">Apply Now</a>
                                </div>
                            </div>
                            </div>   
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- Header End -->
    </header>
    <main>

