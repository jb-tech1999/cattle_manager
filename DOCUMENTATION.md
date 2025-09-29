# API Documentation

## Overview
This document outlines the internal functionality and data flow of the Cattle Manager system.

## Authentication Flow

### Login Process (`index.php`)
1. User enters email and password
2. System validates credentials against `users` table
3. On success, creates session variables:
   - `$_SESSION['loggedin'] = true`
   - `$_SESSION['id'] = userID`
   - `$_SESSION['name'] = user's name`
   - `$_SESSION['email'] = user's email`
4. Redirects to `test.php` (main dashboard)

### Registration Process (`register.php`)
1. Validates user input (name, surname, email, cell, password)
2. Checks for existing email addresses
3. Hashes password using `PASSWORD_DEFAULT`
4. Inserts new user record
5. Sends welcome email
6. Redirects to login page

### Password Reset (`mail.php` & `reset_password.php`)
1. User requests reset via email
2. System validates email exists in database
3. Sends reset link to user's email
4. User follows link to reset password
5. New password is hashed and updated

## Animal Management

### Adding Animals (`test.php`)
**Input Fields:**
- `Number`: Animal identifier (required, must be unique)
- `momID`: Mother's ID (optional)
- `dadID`: Father's ID (optional)  
- `gender`: Male/Female selection
- `dob`: Date of birth

**Process:**
1. Validates animal number is unique
2. Inserts record into `animals` table
3. Links animal to current user via `eienaarID`

### Data Structure
```sql
INSERT INTO animals (id, maID, paID, eienaarID, dob, gender) 
VALUES (animal_number, mother_id, father_id, user_id, birth_date, gender)
```

## Additional Information (`info.php`)
- Provides interface for adding supplementary animal information
- Uses textarea for free-form text input
- Processes data through `test.php` handler

## Data Export (`export.php`)

### Export Process
1. Queries all animals belonging to current user
2. Creates CSV headers: `['Number', 'Mom Number', 'Dad', 'Gender', 'Owner', 'Date of Birth']`
3. Generates CSV file with `Content-Disposition: attachment`
4. Forces browser download as `data.csv`

### SQL Query
```sql
SELECT * FROM animals WHERE eienaarID = '$current_user_id' ORDER BY maID
```

## Session Management

### Session Variables
- `loggedin`: Boolean authentication status
- `id`: User's database ID
- `name`: User's first name
- `email`: User's email address

### Security Measures
1. All pages check authentication status
2. Unauthenticated users redirected to login
3. Sessions destroyed on logout
4. Session variables validated before use

## Database Queries

### Prepared Statements
All user input is processed through prepared statements to prevent SQL injection:

```php
$stmt = $mysqli->prepare("SELECT id FROM animals WHERE id = ?");
$stmt->bind_param('s', $param_number);
$stmt->execute();
```

### Error Handling
- Database connection errors are caught and displayed
- SQL execution failures are handled gracefully
- User-friendly error messages displayed for validation failures

## Form Processing

### POST Request Handling
Each page processes specific POST parameters:

**test.php:**
- `submit`: Add new animal
- `export`: Export data
- `info`: Navigate to info page

**info.php:**
- `submit`: Save additional information
- `export`: Export data

## Email System

### SMTP Configuration
Uses PHP `mail()` function with headers:
```php
$headers = "From: Jandré <jandre@cattle-manager.co.za>\r\n";
$headers .= "Reply-To: jandre@cattle-manager.co.za\r\n";
```

### Email Types
1. **Registration Welcome**: Sent to new users
2. **Admin Notification**: Sent to admin when user registers  
3. **Password Reset**: Contains reset link

## Error Codes

### Common Error Messages
- `"Please enter a number"`: Animal number field empty
- `"This number already exists"`: Duplicate animal number
- `"Please enter your email"`: Email field validation
- `"Password must have atleast 6 characters"`: Password length validation
- `"Passwords did not match"`: Password confirmation mismatch