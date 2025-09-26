# Cattle Manager

A web-based cattle management system built with PHP and MySQL for tracking cattle records, managing animal genealogy, and exporting data.

## Features

- **User Authentication**: Secure user registration, login, and password reset functionality
- **Animal Management**: Add and track cattle with parent information (mother/father)
- **Genealogy Tracking**: Track animal lineage with mother and father IDs
- **Data Export**: Export cattle records to CSV format
- **Additional Information**: Add supplementary information for individual animals
- **Email Notifications**: Automated email notifications for user registration and password resets

## System Requirements

- **Web Server**: Apache or Nginx
- **PHP**: Version 7.0 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Extensions**: PHP mysqli extension
- **Mail**: PHP mail() function configured for email notifications

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/jb-tech1999/cattle_manager.git
cd cattle_manager
```

### 2. Database Setup
1. Create a new MySQL database named `cattle_manager`
2. Import the database schema:
```bash
mysql -u your_username -p cattle_manager < sql/cattle_manager.sql
```

### 3. Configuration
1. Open `config.php` and update the database connection details:
```php
$mysqli = new mysqli('localhost', 'your_username', 'your_password', 'cattle_manager');
$con = mysqli_connect('localhost', 'your_username', 'your_password', 'cattle_manager');
```

### 4. Web Server Setup
1. Copy all files to your web server's document root
2. Ensure proper permissions for PHP execution
3. Configure your web server to use `index.php` as the default page

## Database Schema

### Users Table
- `userID` (int, primary key, auto-increment): Unique user identifier
- `name` (varchar): User's first name
- `surname` (varchar): User's last name
- `email` (varchar): User's email address (used for login)
- `cell` (varchar): User's cell phone number
- `password` (varchar): Hashed password

### Animals Table
- `id` (varchar, primary key): Unique animal identifier/number
- `maID` (varchar): Mother's ID
- `paID` (varchar): Father's ID
- `eienaarID` (int): Owner ID (foreign key to users.userID)
- `dob` (varchar): Date of birth

## Usage Guide

### Getting Started
1. Navigate to the application in your web browser
2. Register a new account or log in with existing credentials
3. Once logged in, you'll be taken to the animal management dashboard

### Adding Animals
1. From the main dashboard (`test.php`), fill in the animal details:
   - **Animal Number**: Unique identifier for the animal
   - **Mother**: ID of the mother animal (optional)
   - **Father**: ID of the father animal (optional)
   - **Gender**: Select Male or Female
   - **Date of Birth**: Select the birth date
2. Click "Add Animal" to save the record

### Adding Additional Information
1. Click "Add info" button to navigate to the information page
2. Enter additional details about the animal in the text area
3. Click "Save" to store the information

### Exporting Data
1. Click the "Export" button from any page
2. Your browser will download a CSV file containing all your cattle records
3. The CSV includes: Number, Mom Number, Dad, Gender, Owner, Date of Birth

### Password Recovery
1. On the login page, click "Forgot password?"
2. Enter your email address
3. Check your email for reset instructions
4. Follow the link to set a new password

## File Structure

```
cattle_manager/
├── config.php              # Database configuration
├── index.php               # Login page
├── register.php            # User registration
├── test.php                # Main dashboard (animal management)
├── info.php                # Additional information page
├── export.php              # CSV export functionality
├── mail.php                # Password reset email
├── reset_password.php      # Password reset form
├── logout.php              # Session termination
├── style.css               # Application styling
├── sql/
│   └── cattle_manager.sql  # Database schema
└── README.md               # This documentation
```

## Security Features

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()` function
- **SQL Injection Protection**: Prepared statements are used for all database queries
- **Session Management**: Secure session handling for user authentication
- **Input Validation**: Server-side validation for all form inputs

## Email Configuration

The application uses PHP's built-in `mail()` function for sending emails. Configure your server's mail settings to enable:
- User registration confirmations
- Password reset emails
- Admin notifications for new users

Default sender: `jandre@cattle-manager.co.za`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Support

For support or questions about the Cattle Manager system, please contact the project maintainer or create an issue in the GitHub repository.

## License

This project is open source. Please check the repository for specific license terms.