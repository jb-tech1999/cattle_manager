# Contributing to Cattle Manager

Thank you for your interest in contributing to the Cattle Manager project! This document provides guidelines and information for contributors.

## Table of Contents
- [Getting Started](#getting-started)
- [Development Setup](#development-setup)
- [Code Style Guidelines](#code-style-guidelines)
- [Making Changes](#making-changes)
- [Testing](#testing)
- [Submitting Changes](#submitting-changes)
- [Reporting Issues](#reporting-issues)

## Getting Started

### Prerequisites
Before contributing, ensure you have:
- PHP 7.0 or higher
- MySQL/MariaDB database
- Web server (Apache/Nginx)
- Git for version control
- Basic understanding of PHP, HTML, CSS, and SQL

### Development Environment
1. Fork the repository
2. Clone your fork locally
3. Set up the development environment following [INSTALL.md](INSTALL.md)
4. Create a new branch for your changes

## Development Setup

### Local Development
```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/cattle_manager.git
cd cattle_manager

# Set up upstream remote
git remote add upstream https://github.com/jb-tech1999/cattle_manager.git

# Create development branch
git checkout -b feature/your-feature-name
```

### Database Setup for Development
```sql
CREATE DATABASE cattle_manager_dev;
-- Import schema
mysql -u root -p cattle_manager_dev < sql/cattle_manager.sql

-- Create test data
INSERT INTO users (name, surname, email, cell, password) 
VALUES ('Test', 'User', 'test@example.com', '1234567890', 
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```

## Code Style Guidelines

### PHP Standards
- Follow PSR-1 and PSR-12 coding standards where applicable
- Use meaningful variable and function names
- Add comments for complex logic
- Sanitize all user inputs
- Use prepared statements for database queries

### Example PHP Code Style
```php
<?php
    // Start with session management
    session_start();
    
    // Include required files
    require_once 'config.php';
    
    // Initialize variables with meaningful names
    $user_email = '';
    $validation_errors = [];
    
    // Process form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate input
        if (empty(trim($_POST['email']))) {
            $validation_errors['email'] = 'Email is required';
        } else {
            $user_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            if (!$user_email) {
                $validation_errors['email'] = 'Invalid email format';
            }
        }
        
        // Process if no errors
        if (empty($validation_errors)) {
            // Use prepared statements
            $sql = 'SELECT id FROM users WHERE email = ?';
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('s', $user_email);
                $stmt->execute();
                // ... rest of logic
            }
        }
    }
?>
```

### HTML/CSS Standards
- Use semantic HTML5 elements
- Maintain responsive design principles
- Follow existing CSS class naming conventions
- Ensure accessibility compliance
- Test across different browsers

### Database Guidelines
- Use descriptive table and column names
- Maintain referential integrity
- Index commonly queried columns
- Use appropriate data types
- Follow existing naming conventions

## Making Changes

### Types of Contributions
- **Bug Fixes**: Resolve existing issues
- **Features**: Add new functionality
- **Documentation**: Improve or add documentation
- **Performance**: Optimize existing code
- **Security**: Address security vulnerabilities

### Coding Process
1. **Plan**: Discuss major changes in issues first
2. **Code**: Write clean, documented code
3. **Test**: Thoroughly test your changes
4. **Document**: Update relevant documentation
5. **Review**: Self-review before submitting

### File Organization
```
cattle_manager/
├── config/              # Configuration files
├── includes/            # Reusable PHP components  
├── assets/              # CSS, JS, images
│   ├── css/
│   ├── js/
│   └── images/
├── pages/               # Individual page files
├── sql/                 # Database scripts
└── docs/                # Documentation
```

## Testing

### Manual Testing Checklist
- [ ] User registration works correctly
- [ ] Login/logout functionality
- [ ] Password reset process
- [ ] Animal creation and validation
- [ ] Data export functionality
- [ ] Email notifications
- [ ] Cross-browser compatibility
- [ ] Mobile responsiveness

### Database Testing
```sql
-- Test data insertion
INSERT INTO animals (id, maID, paID, gender, eienaarID, dob) 
VALUES ('TEST001', 'MOM001', 'DAD001', 'Female', 1, '2021-01-01');

-- Verify constraints
SELECT * FROM animals WHERE eienaarID = 1;

-- Test export query
SELECT id as 'Number', maID as 'Mom Number', paID as 'Dad', 
       gender as 'Gender', eienaarID as 'Owner', dob as 'Date of Birth'
FROM animals WHERE eienaarID = 1;
```

### Security Testing
- Test for SQL injection vulnerabilities
- Verify session management
- Check authentication bypasses  
- Validate input sanitization
- Test password security

## Submitting Changes

### Pull Request Process
1. **Update your branch**
```bash
git fetch upstream
git rebase upstream/master
```

2. **Create descriptive commits**
```bash
git add .
git commit -m "Add animal search functionality

- Implement search by animal number
- Add filtering by gender
- Update UI with search form
- Add corresponding database queries"
```

3. **Push and create PR**
```bash
git push origin feature/your-feature-name
```

4. **PR Description Template**
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Performance improvement

## Testing
- [ ] Manual testing completed
- [ ] Cross-browser testing
- [ ] Database changes tested

## Screenshots (if applicable)
Add screenshots for UI changes

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No console errors
```

## Reporting Issues

### Bug Reports
Use the following template:

```markdown
**Bug Description**
Clear description of the bug

**Steps to Reproduce**
1. Go to...
2. Click on...
3. See error

**Expected Behavior**
What should happen

**Screenshots**
Add screenshots if applicable

**Environment**
- OS: [e.g., Windows 10]
- Browser: [e.g., Chrome 91]
- PHP Version: [e.g., 7.4]
- MySQL Version: [e.g., 8.0]
```

### Feature Requests
```markdown
**Feature Description**
Clear description of the feature

**Use Case**
Why is this feature needed?

**Proposed Solution**
How should it work?

**Additional Context**
Any other relevant information
```

## Code Review Process

### What We Look For
- **Functionality**: Does it work as intended?
- **Security**: Are there any security vulnerabilities?
- **Performance**: Is it efficient?
- **Maintainability**: Is the code readable and well-structured?
- **Documentation**: Is it properly documented?

### Getting Help
- Join discussions in GitHub issues
- Ask questions in pull request comments
- Review existing code for examples
- Check documentation files

## Recognition

Contributors will be recognized in:
- CHANGELOG.md for their contributions
- GitHub contributors list
- Special thanks in release notes

Thank you for contributing to Cattle Manager!