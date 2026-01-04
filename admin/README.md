# Admin Dashboard - Easy Funds 4 You

Complete admin panel for managing loan applications and contact messages.

## Access

**URL**: `http://localhost/EasyFunds4You/admin/login.php`

**Default Credentials:**
- Username: `admin`
- Password: `admin123`

⚠️ **IMPORTANT**: Change the default credentials in `admin/config.php` before deploying to production!

## Features

### Dashboard Overview
- Total applications count
- Pending applications
- Approved applications
- Unread messages count
- Recent applications list
- Recent messages list

### Loan Applications Management
- View all loan applications
- Filter by status (Pending, Approved, Rejected)
- Search by name, email, or phone
- View detailed application information
- Update application status
- View applicant contact details

### Contact Messages Management
- View all contact messages
- Filter by status (Read, Unread)
- Search by name, email, or subject
- View detailed message
- Mark messages as read/unread
- Delete messages
- Reply to messages via email

## Files Structure

```
admin/
├── config.php                 # Admin configuration and authentication
├── login.php                  # Admin login page
├── logout.php                 # Logout handler
├── index.php                  # Dashboard homepage
├── applications.php           # List all applications
├── application_detail.php     # View application details
├── messages.php               # List all messages
├── message_detail.php         # View message details
└── includes/
    ├── header.php             # Admin header with sidebar
    └── footer.php             # Admin footer
```

## Security

1. **Change Default Credentials**: Update `ADMIN_USERNAME` and `ADMIN_PASSWORD` in `admin/config.php`

2. **For Production**, consider:
   - Using password hashing (password_hash())
   - Implementing database-based admin users
   - Adding CSRF protection
   - Using HTTPS
   - Implementing rate limiting on login
   - Adding IP whitelisting (optional)

## Usage

1. **Login**: Go to `/admin/login.php` and enter credentials
2. **Dashboard**: View overview statistics
3. **Applications**: Click "Loan Applications" to view/manage applications
4. **Messages**: Click "Contact Messages" to view/manage messages
5. **Logout**: Click logout button in header

## Pages

### Dashboard (`index.php`)
- Overview statistics
- Recent applications
- Recent messages
- Quick access to all sections

### Applications (`applications.php`)
- List all applications with filters
- Search functionality
- Quick status overview
- Link to detailed view

### Application Detail (`application_detail.php`)
- Complete application information
- Update status (Pending/Approved/Rejected)
- View all applicant details

### Messages (`messages.php`)
- List all messages with filters
- Search functionality
- Quick status overview
- Delete messages
- Link to detailed view

### Message Detail (`message_detail.php`)
- Complete message information
- Update read/unread status
- Reply via email link
- Delete message

## Customization

### Change Admin Credentials

Edit `admin/config.php`:
```php
define('ADMIN_USERNAME', 'your_username');
define('ADMIN_PASSWORD', 'your_password');
```

### Styling

Admin panel uses Bootstrap 4. Customize styles in `admin/includes/header.php` within the `<style>` tag.

## Notes

- All admin pages require login
- Session timeout is handled by PHP session configuration
- Database queries use prepared statements for security
- All user inputs are sanitized












