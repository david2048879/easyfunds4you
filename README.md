<<<<<<< HEAD
# easyfunds4you
Easy funds 4you website
=======
# Easy Funds 4 You - PHP Website

A modern, responsive website for Easy Funds 4 You Ltd, a financial institution offering short-term collateral-based loans in Kigali, Rwanda.

## Features

- **5 Loan Types**: Personal, Business, Asset Finance, Education, and Emergency loans
- **Online Application Form**: Comprehensive loan application with database storage
- **Contact Form**: Customer inquiry form with database storage
- **Responsive Design**: Mobile-friendly layout using Bootstrap
- **PHP Backend**: Server-side processing with MySQL database support

## Project Structure

```
EasyFunds4You/
├── index.php                 # Homepage
├── about.php                 # About Us page
├── services.php              # Services/Loan types page
├── apply.php                 # Loan application form
├── contact.php               # Contact page
├── process_application.php   # Process loan applications
├── process_contact.php       # Process contact form
├── application_success.php   # Success page after application
├── config/
│   └── database.php          # Database configuration
├── includes/
│   ├── header.php            # Common header
│   └── footer.php            # Common footer
├── assets/                   # CSS, JS, images (existing)
└── README.md                 # This file
```

## Setup Instructions

### 1. Database Setup

1. Open phpMyAdmin or MySQL command line
2. Create a new database named `easyfunds4you`:
   ```sql
   CREATE DATABASE easyfunds4you;
   ```
3. Update database credentials in `config/database.php` if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'easyfunds4you');
   ```

Production Level:
   db_name: easyfund_easyfunds4you_db
   db_user: easyfund_easyfunds4you_user
   db_pass: easyfunds4you@123

### 2. File Permissions

Ensure PHP has write permissions for the database operations.

### 3. Web Server Configuration

- **XAMPP/WAMP/MAMP**: Place the project folder in `htdocs` (XAMPP) or `www` (WAMP/MAMP)
- **URL**: Access via `http://localhost/EasyFunds4You/`

### 4. Apache Configuration (if needed)

If using `.htaccess` for clean URLs, ensure `mod_rewrite` is enabled in Apache.

## Database Tables

The application will automatically create the following tables:

1. **loan_applications**: Stores loan application submissions
2. **contact_messages**: Stores contact form submissions

## Pages Overview

### Homepage (index.php)
- Hero section with call-to-action
- About company section
- Services overview (5 loan types)
- Quick application form

### About Page (about.php)
- Company information
- Mission and Vision
- Core Values

### Services Page (services.php)
- Detailed information about all 5 loan types:
  - Personal Loan
  - Business Loan
  - Asset Finance Loan
  - Education Loan
  - Emergency Loan

### Apply Page (apply.php)
- Comprehensive loan application form
- All required fields for loan processing
- Form validation

### Contact Page (contact.php)
- Contact form
- Company address and contact information
- Map placeholder (Google Maps can be integrated)

## Loan Types

1. **Personal Loan**: For individual needs (household expenses, medical care, travel, etc.)
2. **Business Loan**: Working capital for businesses
3. **Asset Finance Loan**: Financing for vehicles, machinery, equipment, electronics
4. **Education Loan**: School fees and educational costs
5. **Emergency Loan**: Rapid relief for urgent financial situations

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript, jQuery
- **Framework**: Bootstrap 4
- **Icons**: Font Awesome, Flaticon

## Company Information

- **Name**: Easy Funds 4 You Ltd
- **Type**: Registered financial institution
- **Services**: Short-term collateral-based loans
- **Location**: Kicukiro Center, opposite to IPRC-Kigali, Kigali, Rwanda
- **Phone**: +250 796 693 784
- **Email**: info@easyfunds4you.rw

## Core Values

- Integrity & Transparency
- Speed & Efficiency
- Customer Focus
- Confidentiality
- Professionalism

## Notes

- The database tables are created automatically on first use
- Form validation is performed on both client and server side
- All user inputs are sanitized to prevent SQL injection
- The application includes error handling and success messages

## Future Enhancements

- Admin panel for managing applications
- Email notifications for new applications
- Google Maps integration for contact page
- File upload for supporting documents
- Online payment integration
- Loan status tracking system

## License

Copyright © Easy Funds 4 You Ltd. All rights reserved.

>>>>>>> 323fc7c (Initial commit)
