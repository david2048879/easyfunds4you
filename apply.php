<?php
$page_title = "Apply for Loan - Easy Funds 4 You";
$page_description = "Apply for a loan with Easy Funds 4 You. Fast and easy application process for personal, business, asset finance, and education loans.";

session_start();

// Get loan type from URL parameter if available
$selected_loan_type = isset($_GET['loan_type']) ? $_GET['loan_type'] : '';
$selected_amount = isset($_GET['amount']) ? $_GET['amount'] : '';
$selected_duration = isset($_GET['duration']) ? $_GET['duration'] : '';

include 'includes/header.php';
?>

        <!-- Hero Start-->
        <div class="hero-area2  slider-height2 hero-overly2 d-flex align-items-center apply-hero">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center pt-50">
                            <h2>Apply Form</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero End -->
        <!-- Apply Area Start -->
        <div class="apply-area pt-150 pb-150">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="application-form-wrapper">
                            <h2 class="form-title">LOAN APPLICATION FORM</h2>
                            <p class="form-subtitle">Fill out the form below to apply for a loan. All fields marked with <span style="color: #EF4444;">*</span> are required.</p>
                            
                            <?php if (isset($_SESSION['errors'])): ?>
                            <div class="application-alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle"></i> Please correct the following errors:</strong>
                                <ul>
                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php 
                            unset($_SESSION['errors']);
                            $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
                            endif; 
                            if (!isset($form_data)) $form_data = []; ?>
                            
                            <!-- Form -->
                            <form action="process_application.php" method="POST" id="loanApplicationForm">
                                
                                <!-- SECTION 1: PERSONAL INFORMATION -->
                                <div class="form-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-user"></i>
                                        SECTION 1: PERSONAL INFORMATION
                                    </h3>
                                    
                                    <div class="row">
                                        <!-- Full Names -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Full Names <span class="required">*</span></label>
                                                <input type="text" name="full_names" id="full_names" class="form-control" placeholder="Enter your full names" value="<?php echo isset($form_data['full_names']) ? htmlspecialchars($form_data['full_names']) : ''; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <!-- National ID / Passport Number -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>National ID / Passport Number <span class="required">*</span></label>
                                                <input type="text" name="national_id" class="form-control" placeholder="Enter National ID or Passport Number" value="<?php echo isset($form_data['national_id']) ? htmlspecialchars($form_data['national_id']) : ''; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Telephone Number -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Telephone Number <span class="required">*</span></label>
                                                <input type="tel" name="telephone" class="form-control" placeholder="+250788123456" value="<?php echo isset($form_data['telephone']) ? htmlspecialchars($form_data['telephone']) : ''; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Email Address (Optional) -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email Address <small>(optional)</small></label>
                                                <input type="email" name="email" class="form-control" placeholder="your.email@example.com" value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>">
                                            </div>
                                        </div>
                                        
                                        <!-- Residential Address -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Residential Address (District / Sector) <span class="required">*</span></label>
                                                <input type="text" name="residential_address" class="form-control" placeholder="Enter District / Sector" value="<?php echo isset($form_data['residential_address']) ? htmlspecialchars($form_data['residential_address']) : ''; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SECTION 2: EMPLOYMENT INFORMATION -->
                                <div class="form-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-briefcase"></i>
                                        SECTION 2: EMPLOYMENT INFORMATION
                                    </h3>
                                    
                                    <div class="form-group">
                                        <label>Employment Category <span class="required">*</span></label>
                                        <div class="radio-group employment-category-group">
                                            <div class="radio-option">
                                                <input type="radio" id="emp_employed" name="employment_category" value="employed" required>
                                                <label for="emp_employed"><strong>1. Employed (with Employer)</strong> - Salaried employee – public or private sector</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" id="emp_self" name="employment_category" value="self_employed" required>
                                                <label for="emp_self"><strong>2. Self-Employed</strong> - Individual earning income independently</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" id="emp_business" name="employment_category" value="business_owner" required>
                                                <label for="emp_business"><strong>3. Business Owner</strong> - Owner or co-owner of a registered business</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" id="emp_other" name="employment_category" value="other" required>
                                                <label for="emp_other"><strong>4. Other (Specify)</strong> - Any income source not covered above</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Employed Fields -->
                                    <div id="employment_employed" class="employment-category-fields" style="display: none;">
                                        <h4>Employed Information</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Employer / Institution Name <span class="required">*</span></label>
                                                    <input type="text" name="employer_name" class="form-control" placeholder="Enter employer/institution name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Job Title / Position <span class="required">*</span></label>
                                                    <input type="text" name="job_title" class="form-control" placeholder="Enter job title/position">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Net Monthly Salary (RWF) <span class="required">*</span></label>
                                                    <input type="number" name="net_monthly_salary" class="form-control" placeholder="Enter net monthly salary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Self-Employed Fields -->
                                    <div id="employment_self_employed" class="employment-category-fields" style="display: none;">
                                        <h4>Self-Employed Information</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Nature of Activity / Service <span class="required">*</span></label>
                                                    <input type="text" name="activity_nature" class="form-control" placeholder="Describe nature of activity/service">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Business Location <span class="required">*</span></label>
                                                    <input type="text" name="business_location" class="form-control" placeholder="Enter business location">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Years of Operation <span class="required">*</span></label>
                                                    <input type="number" name="years_operation" class="form-control" placeholder="Enter years of operation" min="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Average Monthly Income (RWF) <span class="required">*</span></label>
                                                    <input type="number" name="avg_monthly_income" class="form-control" placeholder="Enter average monthly income">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Business Owner Fields -->
                                    <div id="employment_business_owner" class="employment-category-fields" style="display: none;">
                                        <h4>Business Owner Information</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Business Name <span class="required">*</span></label>
                                                    <input type="text" name="business_name" class="form-control" placeholder="Enter business name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Type of Business / Sector <span class="required">*</span></label>
                                                    <input type="text" name="business_type" class="form-control" placeholder="Enter type of business/sector">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Years in Operation <span class="required">*</span></label>
                                                    <input type="number" name="business_years" class="form-control" placeholder="Enter years in operation" min="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Average Monthly Business Income (RWF) <span class="required">*</span></label>
                                                    <input type="number" name="business_monthly_income" class="form-control" placeholder="Enter average monthly business income">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Other Fields -->
                                    <div id="employment_other" class="employment-category-fields" style="display: none;">
                                        <h4>Other Income Source Information</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Description of Income Source <span class="required">*</span></label>
                                                    <textarea name="income_description" class="form-control" rows="3" placeholder="Describe your income source"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Income Frequency <span class="required">*</span></label>
                                                    <select name="income_frequency" class="form-control">
                                                        <option value="">Select frequency</option>
                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                        <option value="seasonal">Seasonal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Estimated Average Monthly Income (RWF) <span class="required">*</span></label>
                                                    <input type="number" name="estimated_monthly_income" class="form-control" placeholder="Enter estimated average monthly income">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SECTION 3: LOAN INFORMATION -->
                                <div class="form-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        SECTION 3: LOAN INFORMATION
                                    </h3>
                                    
                                    <div class="row">
                                        <!-- Type of Loan Requested -->
                                        <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Type of Loan Requested <span class="required">*</span></label>
                                            <div class="checkbox-group">
                                                    <div class="checkbox-option">
                                                        <input type="checkbox" id="loan_business" name="loan_type[]" value="business_expansion">
                                                        <label for="loan_business">Business Expansion</label>
                                                    </div>
                                                    <div class="checkbox-option">
                                                        <input type="checkbox" id="loan_education" name="loan_type[]" value="education">
                                                        <label for="loan_education">Education</label>
                                                    </div>
                                                    <div class="checkbox-option">
                                                        <input type="checkbox" id="loan_purchase" name="loan_type[]" value="purchase_land_equipment">
                                                        <label for="loan_purchase">Purchase of Land / Equipment</label>
                                                    </div>
                                                    <div class="checkbox-option">
                                                        <input type="checkbox" id="loan_other" name="loan_type[]" value="other_personal">
                                                        <label for="loan_other">Other / Personal Purpose</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Loan Amount Requested -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Loan Amount Requested (RWF) <span class="required">*</span></label>
                                                <input type="number" name="loan_amount" id="loan_amount" class="form-control" placeholder="Enter loan amount" value="<?php echo htmlspecialchars($selected_amount); ?>" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Loan Duration -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Loan Duration (Months) <span class="required">*</span></label>
                                                <select name="loan_duration_months" id="loan_duration_months" class="form-control" required>
                                                    <option value="">Choose Duration</option>
                                                    <option value="1">ONE (1 Month)</option>
                                                    <option value="2">TWO (2 Months)</option>
                                                    <option value="3">THREE (3 Months)</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Purpose of the Loan -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Purpose of the Loan (Explain in words) <span class="required">*</span></label>
                                                <textarea name="loan_purpose" class="form-control" rows="4" placeholder="Explain the purpose of the loan..." required><?php echo isset($form_data['loan_purpose']) ? htmlspecialchars($form_data['loan_purpose']) : ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SECTION 4: COLLATERAL INFORMATION -->
                                <div class="form-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-shield-alt"></i>
                                        SECTION 4: COLLATERAL INFORMATION
                                    </h3>
                                    
                                        <div class="form-group">
                                            <label>Type of Collateral Provided <span class="required">*</span></label>
                                            <div class="checkbox-group grid">
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_land" name="collateral_type[]" value="land_title">
                                                <label for="collateral_land">Land Title</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_vehicle" name="collateral_type[]" value="motor_vehicle">
                                                <label for="collateral_vehicle">Motor Vehicle (Car / Motorcycle)</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_household" name="collateral_type[]" value="household_assets">
                                                <label for="collateral_household">Household Assets</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_business" name="collateral_type[]" value="business_assets">
                                                <label for="collateral_business">Business Assets</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_insurance" name="collateral_type[]" value="insurance_policy">
                                                <label for="collateral_insurance">Insurance Policy</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_guarantor" name="collateral_type[]" value="guarantor" class="collateral-guarantor">
                                                <label for="collateral_guarantor">Guarantor</label>
                                            </div>
                                            <div class="checkbox-option">
                                                <input type="checkbox" id="collateral_other" name="collateral_type[]" value="other">
                                                <label for="collateral_other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SECTION 5: GUARANTOR INFORMATION -->
                                <div class="form-section" id="guarantor_section" style="display: none;">
                                    <h3 class="section-title">
                                        <i class="fas fa-users"></i>
                                        SECTION 5: GUARANTOR INFORMATION
                                    </h3>
                                    
                                    <!-- Guarantor 1 -->
                                    <div class="guarantor-block" id="guarantor_1">
                                        <h4>Guarantor 1</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <input type="text" name="guarantor1_name" class="form-control" placeholder="Enter guarantor full name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Telephone Number <span class="required">*</span></label>
                                                    <input type="tel" name="guarantor1_phone" class="form-control" placeholder="+250788123456">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Relationship to Applicant <span class="required">*</span></label>
                                                    <select name="guarantor1_relationship" class="form-control">
                                                        <option value="">Select relationship</option>
                                                        <option value="FAMILY">FAMILY</option>
                                                        <option value="COLLEAGUE">COLLEAGUE</option>
                                                        <option value="FRIEND">FRIEND</option>
                                                        <option value="OTHER">OTHER</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Guarantor 2 (hidden by default) -->
                                    <div class="guarantor-block" id="guarantor_2" style="display: none;">
                                        <h4>Guarantor 2</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <input type="text" name="guarantor2_name" class="form-control" placeholder="Enter guarantor full name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Telephone Number <span class="required">*</span></label>
                                                    <input type="tel" name="guarantor2_phone" class="form-control" placeholder="+250788123456">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Relationship to Applicant <span class="required">*</span></label>
                                                    <select name="guarantor2_relationship" class="form-control">
                                                        <option value="">Select relationship</option>
                                                        <option value="FAMILY">FAMILY</option>
                                                        <option value="COLLEAGUE">COLLEAGUE</option>
                                                        <option value="FRIEND">FRIEND</option>
                                                        <option value="OTHER">OTHER</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Guarantor 3 (hidden by default) -->
                                    <div class="guarantor-block" id="guarantor_3" style="display: none;">
                                        <h4>Guarantor 3</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <input type="text" name="guarantor3_name" class="form-control" placeholder="Enter guarantor full name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Telephone Number <span class="required">*</span></label>
                                                    <input type="tel" name="guarantor3_phone" class="form-control" placeholder="+250788123456">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Relationship to Applicant <span class="required">*</span></label>
                                                    <select name="guarantor3_relationship" class="form-control">
                                                        <option value="">Select relationship</option>
                                                        <option value="FAMILY">FAMILY</option>
                                                        <option value="COLLEAGUE">COLLEAGUE</option>
                                                        <option value="FRIEND">FRIEND</option>
                                                        <option value="OTHER">OTHER</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Add Guarantor Buttons -->
                                    <div class="guarantor-buttons">
                                        <button type="button" class="btn-secondary" id="add_guarantor_2" style="display: none; margin-right: 10px;">
                                            <i class="fas fa-plus"></i> Add Second Guarantor
                                        </button>
                                        <button type="button" class="btn-secondary" id="add_guarantor_3" style="display: none;">
                                            <i class="fas fa-plus"></i> Add Third Guarantor
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- DECLARATION AND CONSENT -->
                                <div class="form-section">
                                    <h3 class="section-title">
                                        <i class="fas fa-file-signature"></i>
                                        DECLARATION AND CONSENT
                                    </h3>
                                    
                                    <div class="form-group">
                                        <div class="declaration-box">
                                            <p>
                                                I, <strong id="declaration_name">[applicant name]</strong>, hereby declare that, to the best of my knowledge, all the information provided in this loan application form is true, accurate, and complete.
                                            </p>
                                            <p>
                                                I authorize EASY FUNDS 4 YOU LTD to conduct any necessary investigations and to request a credit report from TransUnion or any other legally authorized credit reference bureau for the purpose of verifying the information provided and assessing my loan application.
                                            </p>
                                            <p>
                                                I understand that providing false or misleading information may result in the rejection of my application or legal action being taken against me.
                                            </p>
                                        </div>
                                        
                                        <div class="checkbox-option" style="margin-top: 15px;">
                                            <input type="checkbox" id="declaration_agree" name="declaration_agree" required>
                                            <label for="declaration_agree" style="font-weight: 600;">I Agree</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-paper-plane"></i>
                                    SUBMIT APPLICATION
                                </button>
                            </form>
                            
                            <?php 
                            // Clear form data after displaying (only if no errors)
                            if (isset($_SESSION['form_data']) && !isset($_SESSION['errors'])) {
                                unset($_SESSION['form_data']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Apply Area End -->
        
        <script>
        // Form submission handler and dynamic fields
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('loanApplicationForm');
            var submitBtn = document.getElementById('submitBtn');
            var fullNamesInput = document.getElementById('full_names');
            var declarationName = document.getElementById('declaration_name');
            
            // Update declaration name when full names are entered
            if (fullNamesInput && declarationName) {
                fullNamesInput.addEventListener('input', function() {
                    var name = this.value.trim();
                    declarationName.textContent = name || '[applicant name]';
                });
            }
            
            // Employment Category Selection Handler
            var employmentRadios = document.querySelectorAll('input[name="employment_category"]');
            var employmentFields = {
                'employed': document.getElementById('employment_employed'),
                'self_employed': document.getElementById('employment_self_employed'),
                'business_owner': document.getElementById('employment_business_owner'),
                'other': document.getElementById('employment_other')
            };
            
            employmentRadios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Hide all employment category fields
                    Object.values(employmentFields).forEach(function(field) {
                        if (field) field.style.display = 'none';
                    });
                    
                    // Show selected category fields
                    var selectedValue = this.value;
                    if (employmentFields[selectedValue]) {
                        employmentFields[selectedValue].style.display = 'block';
                    }
                });
            });
            
            // Collateral Guarantor Handler
            var collateralGuarantor = document.querySelector('.collateral-guarantor');
            var guarantorSection = document.getElementById('guarantor_section');
            
            if (collateralGuarantor && guarantorSection) {
                collateralGuarantor.addEventListener('change', function() {
                    if (this.checked) {
                        guarantorSection.style.display = 'block';
                    } else {
                        // Check if any other collateral is selected
                        var otherCollaterals = document.querySelectorAll('input[name="collateral_type[]"]:checked');
                        if (otherCollaterals.length === 0 || (otherCollaterals.length === 1 && otherCollaterals[0] === this)) {
                            guarantorSection.style.display = 'none';
                            // Reset guarantors 2 and 3
                            document.getElementById('guarantor_2').style.display = 'none';
                            document.getElementById('guarantor_3').style.display = 'none';
                            document.getElementById('add_guarantor_2').style.display = 'none';
                            document.getElementById('add_guarantor_3').style.display = 'none';
                        }
                    }
                });
            }
            
            // Add Guarantor Handlers
            var addGuarantor2 = document.getElementById('add_guarantor_2');
            var addGuarantor3 = document.getElementById('add_guarantor_3');
            var guarantor2Block = document.getElementById('guarantor_2');
            var guarantor3Block = document.getElementById('guarantor_3');
            
            if (addGuarantor2 && guarantor2Block) {
                addGuarantor2.addEventListener('click', function() {
                    guarantor2Block.style.display = 'block';
                    this.style.display = 'none';
                    addGuarantor3.style.display = 'inline-block';
                });
            }
            
            if (addGuarantor3 && guarantor3Block) {
                addGuarantor3.addEventListener('click', function() {
                    guarantor3Block.style.display = 'block';
                    this.style.display = 'none';
                });
            }
            
            // Show "Add Second Guarantor" button when guarantor section is visible
            if (guarantorSection && addGuarantor2) {
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.target.style.display === 'block') {
                            addGuarantor2.style.display = 'inline-block';
                        }
                    });
                });
                
                observer.observe(guarantorSection, {
                    attributes: true,
                    attributeFilter: ['style']
                });
            }
            
            // Form submission handler
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Validate loan type checkbox (at least one selected)
                    var loanTypes = document.querySelectorAll('input[name="loan_type[]"]:checked');
                    if (loanTypes.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one type of loan requested.');
                        return false;
                    }
                    
                    // Validate collateral type checkbox (at least one selected)
                    var collateralTypes = document.querySelectorAll('input[name="collateral_type[]"]:checked');
                    if (collateralTypes.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one type of collateral provided.');
                        return false;
                    }
                    
                    // Validate employment category fields based on selection
                    var selectedEmployment = document.querySelector('input[name="employment_category"]:checked');
                    if (selectedEmployment) {
                        var categoryFields = employmentFields[selectedEmployment.value];
                        if (categoryFields) {
                            var requiredFields = categoryFields.querySelectorAll('[required]');
                            var allFilled = true;
                            requiredFields.forEach(function(field) {
                                if (!field.value.trim()) {
                                    allFilled = false;
                                }
                            });
                            if (!allFilled) {
                                e.preventDefault();
                                alert('Please fill in all required fields for the selected employment category.');
                                return false;
                            }
                        }
                    }
                    
                    // Disable button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                    
                    // Allow form to submit normally
                    return true;
                });
            }
        });
        </script>
        
        <style>
        .employment-category-group {
            flex-direction: column;
            gap: 15px;
        }
        
        .guarantor-buttons {
            margin-top: 20px;
        }
        </style>

<?php include 'includes/footer.php'; ?>

