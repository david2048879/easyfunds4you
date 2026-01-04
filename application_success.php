<?php
session_start();

// Check if application was successful
if (!isset($_SESSION['success']) || !$_SESSION['success']) {
    header('Location: apply.php');
    exit;
}

$application_id = isset($_SESSION['application_id']) ? $_SESSION['application_id'] : '';
$page_title = "Application Submitted - Easy Funds 4 You";
$page_description = "Your loan application has been submitted successfully.";

// Clear session data after displaying
unset($_SESSION['success']);
unset($_SESSION['application_id']);

include 'includes/header.php';
?>

        <!-- Hero Start-->
        <div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Application Submitted</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        
        <!-- Success Message Area -->
        <div class="apply-area pt-150 pb-150">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center">
                            <div class="success-icon mb-30">
                                <i class="fas fa-check-circle" style="font-size: 80px; color: #409645;"></i>
                            </div>
                            <h2 class="mb-30">Thank You!</h2>
                            <p class="mb-30" style="font-size: 18px;">Your loan application has been submitted successfully.</p>
                            
                            <?php if ($application_id): ?>
                            <p class="mb-30"><strong>Application ID:</strong> #<?php echo str_pad($application_id, 6, '0', STR_PAD_LEFT); ?></p>
                            <?php endif; ?>
                            
                            <p class="mb-40">Our team will review your application and contact you within 24 hours. Please keep your phone nearby as we may call you for additional information.</p>
                            
                            <div class="contact-info-box mb-40" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                                <h4 class="mb-20">Need to contact us?</h4>
                                <p><i class="fas fa-phone"></i> <a href="tel:+250796693784">+250 796 693 784</a></p>
                                <p><i class="fas fa-envelope"></i> <a href="mailto:info@easyfunds4you.rw">info@easyfunds4you.rw</a></p>
                                <p><i class="fas fa-map-marker-alt"></i> Kicukiro Center, opposite to IPRC-Kigali, Kigali, Rwanda</p>
                            </div>
                            
                            <div class="action-buttons">
                                <a href="index.php" class="btn mr-3">Back to Home</a>
                                <a href="services.php" class="btn">View Our Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Success Message Area End -->

<?php include 'includes/footer.php'; ?>












