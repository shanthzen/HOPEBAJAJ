# Hope Bajaj Project Deployment Instructions

## Prerequisites
- XAMPP with PHP 8.2.12
- MySQL
- Composer

## Deployment Steps

1. **Setup Project Files**
   ```bash
   # Copy the entire project folder to your xampp/htdocs directory
   # Example: C:\xampp\htdocs\Hope Bajaj
   ```

2. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `hope_student_management`
   - Import the database from `database/hope_student_management.sql`

3. **Storage Setup**
   ```bash
   # Copy storage files
   xcopy /E /I /H /Y "storage\*" "storage\app\public\"
   
   # Create storage link
   php artisan storage:link
   ```

4. **Environment Setup**
   - Copy `.env.example` to `.env`
   - Update database credentials in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=hope_student_management
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Install Dependencies**
   ```bash
   composer install
   ```

6. **Clear Cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

7. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

## Verification Steps

1. Open http://localhost/Hope%20Bajaj/public in your browser
2. Try logging in with an existing account
3. Verify that student photos and signatures are visible
4. Test the password reset functionality

## Common Issues

1. **Photos Not Visible**
   - Ensure storage link is created
   - Check file permissions on storage directory
   - Verify storage files are in correct location

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Ensure MySQL service is running
   - Check database name matches

3. **500 Server Error**
   - Check storage and bootstrap/cache folder permissions
   - Ensure all required PHP extensions are enabled
   - Review Laravel error logs in storage/logs

## Support

If you encounter any issues during deployment, please check:
1. Laravel logs at `storage/logs/laravel.log`
2. PHP error logs in XAMPP
3. Make sure all required PHP extensions are enabled in php.ini
