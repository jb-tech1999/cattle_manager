# Installation and Setup Guide

## Prerequisites

Before installing Cattle Manager, ensure you have the following:

### System Requirements
- **Operating System**: Linux, Windows, or macOS
- **Web Server**: Apache 2.4+ or Nginx 1.10+
- **PHP**: Version 7.0 or higher with the following extensions:
  - mysqli
  - session
  - mail (for email functionality)
- **Database**: MySQL 5.7+ or MariaDB 10.2+

## Installation Methods

### Method 1: Manual Installation

#### Step 1: Download and Extract
```bash
# Clone from GitHub
git clone https://github.com/jb-tech1999/cattle_manager.git
cd cattle_manager

# Or download ZIP and extract
wget https://github.com/jb-tech1999/cattle_manager/archive/master.zip
unzip master.zip
cd cattle_manager-master
```

#### Step 2: Database Setup

1. **Create Database**
```sql
CREATE DATABASE cattle_manager;
CREATE USER 'cattle_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON cattle_manager.* TO 'cattle_user'@'localhost';
FLUSH PRIVILEGES;
```

2. **Import Schema**
```bash
mysql -u cattle_user -p cattle_manager < sql/cattle_manager.sql
```

#### Step 3: Configure Application

1. **Update config.php**
```php
<?php
    // Update these with your database credentials
    $mysqli = new mysqli('localhost', 'cattle_user', 'your_secure_password', 'cattle_manager');
    $con = mysqli_connect('localhost', 'cattle_user', 'your_secure_password', 'cattle_manager');
    
    // Check connection
    if ($mysqli === false) {
        die("Error: Could not connect. " . mysqli_connect_error());
    }
?>
```

#### Step 4: Set File Permissions
```bash
# Make files readable by web server
chmod -R 644 .
chmod -R 755 .
chmod 755 *.php
```

#### Step 5: Web Server Configuration

**For Apache:**
Create `.htaccess` file (optional):
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
```

**For Nginx:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/cattle_manager;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Method 2: Docker Installation (Optional)

Create `Dockerfile`:
```dockerfile
FROM php:7.4-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

EXPOSE 80
```

Create `docker-compose.yml`:
```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "8080:80"
    depends_on:
      - db
    volumes:
      - .:/var/www/html/

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: cattle_manager
      MYSQL_USER: cattle_user
      MYSQL_PASSWORD: userpassword
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      - ./sql/cattle_manager.sql:/docker-entrypoint-initdb.d/init.sql

volumes:
  mysql_data:
```

Run with:
```bash
docker-compose up -d
```

## Email Configuration

### PHP Mail Configuration

1. **Edit php.ini**:
```ini
[mail function]
SMTP = localhost
smtp_port = 25
sendmail_from = noreply@yourdomain.com
```

2. **For Gmail SMTP** (using PHPMailer - requires additional setup):
Install PHPMailer and configure:
```php
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
```

## Testing the Installation

### 1. Access Check
Navigate to `http://your-domain.com` or `http://localhost/cattle_manager`

### 2. Database Connection Test
Create `test_connection.php`:
```php
<?php
include 'config.php';

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
echo 'Connected successfully to database';
?>
```

### 3. Create Test User
```sql
INSERT INTO users (name, surname, email, cell, password) 
VALUES ('Test', 'User', 'test@example.com', '1234567890', '$2y$10$example_hash');
```

## Troubleshooting

### Common Issues

**1. Database Connection Failed**
- Check database credentials in `config.php`
- Verify MySQL service is running
- Confirm user permissions

**2. Email Not Sending**
- Check PHP mail configuration
- Verify mail server settings
- Check server mail logs

**3. Session Issues**
- Ensure proper session directory permissions
- Check PHP session configuration
- Clear browser cookies

**4. File Upload Errors**
- Check directory permissions
- Verify PHP upload settings in `php.ini`

### Debug Mode

Enable error reporting for debugging:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Your application code
?>
```

## Security Considerations

### Production Security

1. **Update config.php** for production:
```php
// Disable error display
error_reporting(0);
ini_set('display_errors', 0);

// Use environment variables
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'cattle_user';
$db_pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME') ?: 'cattle_manager';
```

2. **SSL/TLS**: Always use HTTPS in production
3. **Database**: Use strong passwords and limit user privileges
4. **File Permissions**: Restrict file permissions appropriately
5. **Updates**: Keep PHP, MySQL, and web server updated

## Backup Procedures

### Database Backup
```bash
# Daily backup
mysqldump -u cattle_user -p cattle_manager > backup_$(date +%Y%m%d).sql

# Automated backup script
#!/bin/bash
BACKUP_DIR="/backups/cattle_manager"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u cattle_user -p cattle_manager > "$BACKUP_DIR/backup_$DATE.sql"
find $BACKUP_DIR -name "backup_*.sql" -mtime +30 -delete
```

### File Backup
```bash
# Backup application files
tar -czf cattle_manager_backup_$(date +%Y%m%d).tar.gz /path/to/cattle_manager
```

## Maintenance

### Regular Tasks
1. **Database Optimization**: Run weekly
2. **Log Rotation**: Configure log file rotation
3. **Security Updates**: Apply monthly
4. **Backup Verification**: Test restore procedures
5. **Performance Monitoring**: Monitor resource usage