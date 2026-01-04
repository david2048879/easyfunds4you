<?php
$page_title = "Our Services - Easy Funds 4 You";
$page_description = "Explore our comprehensive loan services: Personal Loans, Business Loans, Asset Finance, Education Loans, and Emergency Loans. Fast and reliable financing solutions in Kigali, Rwanda.";
include 'includes/header.php';

// Loan services data
$loan_services = [
    [
        'title' => 'Personal Loan',
        'icon' => 'flaticon-work',
        'short_desc' => 'Supports individual needs quickly with flexible personal loans.',
        'description' => 'We do provide personal loans to support individual needs such as household expenses, family support, medical care, travel, or any other personal financial requirements. These loans are based on the client\'s income and repayment ability.',
        'cta' => 'Apply now and get cash fast.'
    ],
    [
        'title' => 'Business Loan',
        'icon' => 'flaticon-loan',
        'short_desc' => 'Empowers business growth with reliable working-capital financing.',
        'description' => 'We do provide business loans to help entrepreneurs and companies access working capital, purchase stock, expand operations, or strengthen daily business activities. Our aim is to support business growth and sustainability.',
        'cta' => 'Boost your business—apply for funding today.'
    ],
    [
        'title' => 'Asset Finance Loan',
        'icon' => 'flaticon-loan-1',
        'short_desc' => 'Enables you to acquire essential assets affordably.',
        'description' => 'We do provide asset finance for clients wishing to acquire assets such as vehicles, machinery, equipment, electronics, and other tools necessary for work or business operations. In most cases, the financed asset can serve as collateral.',
        'cta' => 'Own the tools you need now.'
    ],
    [
        'title' => 'Education Loan',
        'icon' => 'flaticon-like',
        'short_desc' => 'Makes school fees manageable with supportive education financing.',
        'description' => 'We do provide education loans to assist clients in paying school fees, tuition, and other educational costs for themselves or their dependents. This ensures uninterrupted learning throughout the academic year.',
        'cta' => 'Invest in education—apply with us.'
    ],
    [
        'title' => 'Emergency Loan',
        'icon' => 'flaticon-money',
        'short_desc' => 'Provides rapid relief during unexpected financial crises.',
        'description' => 'We do provide emergency loans designed for urgent situations such as medical needs, sudden family issues, or unexpected financial challenges. These loans are processed quickly to provide immediate support when it is needed most.',
        'cta' => 'Get urgent funds when it matters.'
    ]
];
?>

        <!-- Hero Start-->
        <div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center services-hero">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Services</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        <!-- Services Area Start -->
        <div class="services-area section-padding30">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <!-- Section Tittle -->
                        <div class="section-tittle text-center mb-80">
                            <span>Services that we are providing</span>
                            <h2>Comprehensive Loan Solutions For All Your Needs.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($loan_services as $service): ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat single-cat2 text-center mb-50">
                            <div class="cat-icon">
                                <span class="<?php echo $service['icon']; ?>"></span>
                            </div>
                            <div class="cat-cap">
                                <h5><a href="apply.php?loan_type=<?php echo strtolower(str_replace(' ', '_', $service['title'])); ?>"><?php echo $service['title']; ?></a></h5>
                                <p><?php echo $service['short_desc']; ?> <?php echo $service['cta']; ?></p>
                                <a href="apply.php?loan_type=<?php echo strtolower(str_replace(' ', '_', $service['title'])); ?>" class="btn">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                 </div>
            </div>
        </div>
        <!-- Services Area End -->
        
        <!-- Detailed Services Section -->
        <div class="services-area section-padding30" style="background: #f8f9fa;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="section-tittle text-center mb-80">
                            <span>Loan Details</span>
                            <h2>Detailed Information About Our Loan Services</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($loan_services as $index => $service): ?>
                    <div class="col-lg-12 mb-50">
                        <div class="single-service-detail">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <div class="service-icon-large">
                                        <span class="<?php echo $service['icon']; ?>" style="font-size: 60px; color: #409645;"></span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <h3><?php echo $service['title']; ?></h3>
                                    <p><?php echo $service['description']; ?></p>
                                    <a href="apply.php?loan_type=<?php echo strtolower(str_replace(' ', '_', $service['title'])); ?>" class="btn">Apply for <?php echo $service['title']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($index < count($loan_services) - 1): ?>
                    <div class="col-12"><hr style="border-top: 1px solid #ddd; margin: 30px 0;"></div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Detailed Services Section End -->

<?php include 'includes/footer.php'; ?>



