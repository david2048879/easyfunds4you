-- News Table Schema for Easy Funds 4 You
-- This table stores news articles/posts

CREATE TABLE IF NOT EXISTS `news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL COMMENT 'News article title',
  `content` TEXT NOT NULL COMMENT 'Full news article content',
  `excerpt` VARCHAR(500) DEFAULT NULL COMMENT 'Short description/excerpt for listings',
  `image` VARCHAR(255) DEFAULT NULL COMMENT 'Path to news image (uploaded or URL)',
  `author` VARCHAR(100) DEFAULT 'Admin' COMMENT 'Author of the news article',
  `status` ENUM('published', 'draft') DEFAULT 'published' COMMENT 'Publication status',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when news was created',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date and time when news was last updated',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='News articles and blog posts';

-- Sample data (optional)
-- INSERT INTO `news` (`title`, `content`, `excerpt`, `image`, `author`, `status`) VALUES
-- ('New Loan Products Available for 2024', 'We are excited to announce the launch of our new loan products designed to better serve our customers in Kigali and surrounding areas.', 'We are excited to announce the launch of our new loan products designed to better serve our customers.', 'assets/img/gallery/home_blog1.png', 'Admin', 'published'),
-- ('Faster Loan Approval Process', 'We\'ve streamlined our loan approval process to provide faster service. Most applications are now processed within 24 hours.', 'We\'ve streamlined our loan approval process to provide faster service.', 'assets/img/gallery/home_blog2.png', 'Admin', 'published');










