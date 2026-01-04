<?php
$page_title = "Contact Us - Easy Funds 4 You";
$page_description = "Contact Easy Funds 4 You for loan inquiries. Reach us at +250796693784 or visit us at Kicukiro Center, Kigali, Rwanda.";
session_start();

// Preserve form data for error display
$form_data = isset($_SESSION['contact_data']) ? $_SESSION['contact_data'] : [];

include 'includes/header.php';
?>

        <!-- Hero Start-->
        <div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center contact-hero">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        <!-- ================ contact section start ================= -->
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="contact-form-wrapper">
                            <h2 class="form-title">Get in Touch</h2>
                            <p class="form-subtitle">Fill out the form below and we'll get back to you as soon as possible.</p>
                            
                            <?php if (isset($_SESSION['contact_success'])): ?>
                            <div class="contact-alert alert-success">
                                <strong><i class="fas fa-check-circle"></i> Success!</strong> Your message has been sent successfully. We'll get back to you soon!
                            </div>
                            <?php 
                            unset($_SESSION['contact_success']); 
                            $form_data = []; // Clear form data on success
                            endif; ?>
                            
                            <?php if (isset($_SESSION['contact_errors'])): ?>
                            <div class="contact-alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle"></i> Error!</strong>
                                <ul>
                                    <?php foreach ($_SESSION['contact_errors'] as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php 
                            unset($_SESSION['contact_errors']); 
                            endif; ?>
                            
                            <form action="process_contact.php" method="post" id="contactForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="name" 
                                                name="name" 
                                                placeholder="Enter your full name" 
                                                value="<?php echo isset($form_data['name']) ? htmlspecialchars($form_data['name']) : ''; ?>" 
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input 
                                                type="email" 
                                                class="form-control" 
                                                id="email" 
                                                name="email" 
                                                placeholder="your.email@example.com" 
                                                value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>" 
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject">Subject <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="subject" 
                                        name="subject" 
                                        placeholder="What is this regarding?" 
                                        value="<?php echo isset($form_data['subject']) ? htmlspecialchars($form_data['subject']) : ''; ?>" 
                                        required
                                    >
                                </div>
                                
                                <div class="form-group">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea 
                                        class="form-control" 
                                        id="message" 
                                        name="message" 
                                        rows="6" 
                                        placeholder="Tell us more about your inquiry..." 
                                        required
                                    ><?php echo isset($form_data['message']) ? htmlspecialchars($form_data['message']) : ''; ?></textarea>
                                </div>
                                
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </form>
                            <script>
                            // Ensure form submits properly - run after all scripts load
                            window.addEventListener('load', function() {
                                var form = document.getElementById('contactForm');
                                var submitBtn = document.getElementById('submitBtn');
                                
                                if (!form || !submitBtn) return;
                                
                                // Remove any jQuery validation or AJAX handlers
                                if (typeof jQuery !== 'undefined') {
                                    jQuery(form).off('submit.validate submit.form-plugin submit');
                                    if (jQuery(form).data('validator')) {
                                        jQuery(form).data('validator', null);
                                    }
                                }
                                
                                // Simple submit handler - just ensure it submits
                                form.onsubmit = function(e) {
                                    // Disable button to prevent double submission
                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                                    
                                    // Allow form to submit normally - browser will validate required fields
                                    return true;
                                };
                            });
                            </script>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="contact-info-modern">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4 class="info-title">Our Location</h4>
                            <p class="info-text">Kicukiro Center<br>Opposite to IPRC-Kigali<br>Kigali, Rwanda</p>
                        </div>
                        
                        <div class="contact-info-modern">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h4 class="info-title">
                                <a href="tel:+250796693784">+250 796 693 784</a>
                            </h4>
                            <p class="info-text">Mon to Fri 8am to 6pm<br>Sat 9am to 1pm</p>
                        </div>
                        
                        <div class="contact-info-modern">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h4 class="info-title">
                                <a href="mailto:info@easyfunds4you.rw">info@easyfunds4you.rw</a>
                            </h4>
                            <p class="info-text">Send us your query anytime!<br>Our team will reply within a day</p>
                        </div>
                        
                        <!-- Map Section -->
                        <div class="contact-map-modern" style="margin-top: 30px;">
                            <div style="width: 100%; height: 300px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: #f5f5f5; position: relative;">
                                <iframe 
                                    src="https://www.google.com/maps?q=Kicukiro+Center,+Opposite+to+IPRC-Kigali,+Kigali,+Rwanda&output=embed" 
                                    width="100%" 
                                    height="300" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                            <p style="margin-top: 10px; font-size: 12px; color: #666; text-align: center;">
                                <a href="https://maps.app.goo.gl/JFP1NqL9mViHYWXE7" target="_blank" style="color: #2F855A; text-decoration: none;">
                                    <i class="fas fa-external-link-alt"></i> Open in Google Maps
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ contact section end ================= -->

<?php include 'includes/footer.php'; ?>

