@echo off
echo Restoring storage files...
if not exist "storage\app\public" mkdir "storage\app\public"
xcopy /E /I /H /Y "storage\*" "storage\app\public\"

echo Creating storage link...
php artisan storage:link

echo Clearing Laravel cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo Done! Please make sure to:
echo 1. Import the database
echo 2. Update .env file with your database credentials
echo 3. Run: composer install
pause
