-- Easy Funds 4 You Database Setup
-- Run this script in phpMyAdmin or MySQL command line

-- Create database
CREATE DATABASE IF NOT EXISTS easyfunds4you CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE easyfunds4you;

-- Table for loan applications (Updated Schema - December 2024)
CREATE TABLE IF NOT EXISTS loan_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- SECTION 1: PERSONAL INFORMATION
    full_names VARCHAR(255) NOT NULL,
    national_id VARCHAR(100) NOT NULL,
    telephone VARCHAR(50) NOT NULL,
    email VARCHAR(255),
    residential_address TEXT NOT NULL,
    
    -- SECTION 2: EMPLOYMENT INFORMATION
    employment_category VARCHAR(50) NOT NULL,
    -- Employed fields
    employer_name VARCHAR(255),
    job_title VARCHAR(255),
    net_monthly_salary DECIMAL(15,2),
    -- Self-Employed fields
    activity_nature VARCHAR(255),
    business_location VARCHAR(255),
    years_operation INT,
    avg_monthly_income DECIMAL(15,2),
    -- Business Owner fields
    business_name VARCHAR(255),
    business_type VARCHAR(255),
    business_years INT,
    business_monthly_income DECIMAL(15,2),
    -- Other income source fields
    income_description TEXT,
    income_frequency VARCHAR(50),
    estimated_monthly_income DECIMAL(15,2),
    
    -- SECTION 3: LOAN INFORMATION
    loan_type TEXT NOT NULL COMMENT 'Comma-separated loan types',
    loan_amount DECIMAL(15,2) NOT NULL,
    loan_duration_months VARCHAR(10) NOT NULL COMMENT 'ONE, TWO, or THREE months',
    loan_purpose TEXT NOT NULL,
    
    -- SECTION 4: COLLATERAL INFORMATION
    collateral_type TEXT NOT NULL COMMENT 'Comma-separated collateral types',
    
    -- SECTION 5: GUARANTOR INFORMATION
    guarantor1_name VARCHAR(255),
    guarantor1_phone VARCHAR(50),
    guarantor1_relationship VARCHAR(50),
    guarantor2_name VARCHAR(255),
    guarantor2_phone VARCHAR(50),
    guarantor2_relationship VARCHAR(50),
    guarantor3_name VARCHAR(255),
    guarantor3_phone VARCHAR(50),
    guarantor3_relationship VARCHAR(50),
    
    -- STATUS AND TIMESTAMP
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- INDEXES
    INDEX idx_email (email),
    INDEX idx_national_id (national_id),
    INDEX idx_status (status),
    INDEX idx_employment_category (employment_category),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for news articles
CREATE TABLE IF NOT EXISTS news (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL COMMENT 'News article title',
    content TEXT NOT NULL COMMENT 'Full news article content',
    excerpt VARCHAR(500) DEFAULT NULL COMMENT 'Short description/excerpt for listings',
    image VARCHAR(255) DEFAULT NULL COMMENT 'Path to news image (uploaded or URL)',
    author VARCHAR(100) DEFAULT 'Admin' COMMENT 'Author of the news article',
    status ENUM('published', 'draft') DEFAULT 'published' COMMENT 'Publication status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when news was created',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date and time when news was last updated',
    PRIMARY KEY (id),
    KEY idx_status (status),
    KEY idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='News articles and blog posts';



