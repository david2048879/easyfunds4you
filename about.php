<?php
$page_title = "About Us - Easy Funds 4 You";
$page_description = "Learn about Easy Funds 4 You Ltd, a registered financial institution offering fast, secure, and reliable collateral-based short-term loans in Kigali, Rwanda.";
include 'includes/header.php';
?>

        <!-- Hero Start-->
        <div class="hero-area2 slider-height2 hero-overly2 d-flex align-items-center about-us-hero">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>About Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        
        <!-- About Page Modern -->
        <section class="about-page-modern">
            <div class="container">
                <!-- About Intro Section -->
                <div class="about-intro-section">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="about-intro-content">
                                <div class="section-label" style="color: #2F855A; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px;">About Our Company</div>
                                <h2>Building a Brighter Financial Future & Good Support</h2>
                                <p class="intro-text">Easy Funds 4 You Ltd is a registered financial institution offering short-term collateral-based loans to individuals, employees, and small business owners who need immediate financial assistance.</p>
                                <p class="intro-text">Our goal is to provide fast, secure, and reliable credit support while maintaining transparency and professionalism. We process loans quickly, ensuring that clients receive the financial help they need—when they need it.</p>
                                <a href="apply.php" class="btn" style="background: #2F855A; color: #FFFFFF; padding: 14px 32px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s ease;">Apply for Loan</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="office-image" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                                <img src="assets/img/Hero.png" alt="Easy Funds 4 You - Financial Solutions" style="width: 100%; height: 500px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mission & Vision -->
                <div class="mission-vision-grid">
                    <div class="mission-vision-card">
                        <div class="card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>To provide fast and reliable collateral-based short-term loans that empower individuals and small businesses to meet urgent financial needs with confidence.</p>
                    </div>
                    <div class="mission-vision-card">
                        <div class="card-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p>To become the most trusted and customer-focused short-term lending institution in Kigali and beyond.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Page Modern End-->

        <!-- Core Values Section -->
        <section class="core-values-section">
            <div class="container">
                <div class="section-header-modern">
                    <div class="section-label">Our Values</div>
                    <h2>Core Values That Guide Us</h2>
                    <p>Our core values guide everything we do and reflect our commitment to serving our clients with excellence and integrity</p>
                </div>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Integrity & Transparency</h4>
                        <p>Honest and clear communication in all our dealings</p>
                    </div>
                    <div class="value-card">
                        <div class="value-card-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h4>Speed & Efficiency</h4>
                        <p>Fast loan processing and quick disbursement</p>
                    </div>
                    <div class="value-card">
                        <div class="value-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Customer Focus</h4>
                        <p>Your needs are our top priority</p>
                    </div>
                    <div class="value-card">
                        <div class="value-card-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Confidentiality</h4>
                        <p>Your personal information is always protected</p>
                    </div>
                    <div class="value-card">
                        <div class="value-card-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Professionalism</h4>
                        <p>Expert service with the highest standards</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Core Values Section End -->
        <!-- Application Area Start -->
        <div class="application-area pt-150 pb-140" data-background="assets/img/gallery/section_bg03.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle section-tittle2 text-center mb-45">
                            <span>Apply in Three Easy Steps</span>
                            <h2>Easy Application Process For Any Types of Loan</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-xl-8">
                        <!--Hero form -->
                        <form action="apply.php" class="search-box" method="GET">
                            <div class="select-form">
                                <div class="select-itms">
                                    <select name="amount" id="select1">
                                        <option value="">Select Amount</option>
                                        <option value="50000">RWF 50,000</option>
                                        <option value="100000">RWF 100,000</option>
                                        <option value="250000">RWF 250,000</option>
                                        <option value="500000">RWF 500,000</option>
                                        <option value="1000000">RWF 1,000,000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-form">
                                <div class="select-itms">
                                    <select name="duration" id="select2">
                                        <option value="">Duration</option>
                                        <option value="7">7 Days</option>
                                        <option value="14">14 Days</option>
                                        <option value="30">30 Days</option>
                                        <option value="60">60 Days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-form">
                                <div class="select-itms">
                                    <select name="loan_type" id="select3">
                                        <option value="">Loan Type</option>
                                        <option value="personal">Personal Loan</option>
                                        <option value="business">Business Loan</option>
                                        <option value="asset">Asset Finance</option>
                                        <option value="education">Education Loan</option>
                                        <option value="emergency">Emergency Loan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="search-form">
                                <button type="submit" class="btn">Apply for Loan</button>
                            </div>	
                        </form>	
                    </div>
                </div>
            </div>
        </div>
        <!-- Application Area End -->

<?php include 'includes/footer.php'; ?>

