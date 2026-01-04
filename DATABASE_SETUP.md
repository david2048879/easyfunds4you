# Database Setup Guide

## Where is the Database?

The database configuration is located in: **`config/database.php`**

The actual MySQL database needs to be created. The database will be named: **`easyfunds4you`**

## How to Set Up the Database

### Option 1: Using phpMyAdmin (Recommended for XAMPP)

1. **Start XAMPP**
   - Make sure Apache and MySQL are running in XAMPP Control Panel

2. **Open phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin` in your browser
   - Or click "Admin" button next to MySQL in XAMPP Control Panel

3. **Create the Database**
   - Click on "New" in the left sidebar
   - Enter database name: `easyfunds4you`
   - Choose collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. **Import Tables (Optional - They will be created automatically)**
   - Click on the `easyfunds4you` database
   - Click "Import" tab
   - Choose the `database_setup.sql` file
   - Click "Go"

   **OR** The tables will be created automatically when you submit the first form!

### Option 2: Using MySQL Command Line

1. Open Command Prompt (Windows) or Terminal
2. Navigate to MySQL bin directory (if not in PATH):
   ```bash
   cd C:\xampp\mysql\bin
   ```
3. Login to MySQL:
   ```bash
   mysql -u root -p
   ```
   (Press Enter if no password, or enter your MySQL password)

4. Run the SQL commands:
   ```sql
   CREATE DATABASE easyfunds4you CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE easyfunds4you;
   ```
   
5. Or run the entire SQL file:
   ```bash
   mysql -u root -p < database_setup.sql
   ```

### Option 3: Automatic Table Creation

**No need to create tables manually!** The application will automatically create the tables when:
- First loan application is submitted
- First contact message is sent

Just make sure the database `easyfunds4you` exists first (Option 1 or 2 above).

## Database Configuration

Current settings in `config/database.php`:

```php
DB_HOST: 'localhost'
DB_USER: 'root'
DB_PASS: '' (empty - default XAMPP)
DB_NAME: 'easyfunds4you'
```

**If your MySQL has a password**, edit `config/database.php`:
```php
define('DB_PASS', 'your_password_here');
```

## Tables Created

1. **loan_applications** - Stores all loan application submissions
2. **contact_messages** - Stores contact form submissions

## Verify Database Setup

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click on `easyfunds4you` database
3. You should see the tables: `loan_applications` and `contact_messages`
4. Try submitting a test application or contact form on the website

## Troubleshooting

**Error: "Connection failed"**
- Make sure MySQL is running in XAMPP Control Panel
- Check if database name is correct: `easyfunds4you`
- Verify username is `root` and password (if set) in `config/database.php`

**Error: "Access denied"**
- Check MySQL username and password in `config/database.php`
- Default XAMPP username is `root` with no password

**Tables not appearing**
- Submit a form on the website - tables are created automatically
- Or manually run the `database_setup.sql` file

## Need Help?

- Check XAMPP MySQL is running
- Verify database exists in phpMyAdmin
- Check `config/database.php` credentials
- Review error logs in XAMPP












