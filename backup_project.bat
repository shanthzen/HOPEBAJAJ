@echo off
echo Creating backup directories...
mkdir "backup_hope"
mkdir "backup_hope\database"
mkdir "backup_hope\storage"

echo Copying project files...
xcopy /E /I /H /Y "." "backup_hope\"

echo Backing up storage files...
xcopy /E /I /H /Y "storage\app\public\*" "backup_hope\storage\"

echo Done! Your backup is ready in the backup_hope folder.
echo.
echo To restore on another system:
echo 1. Copy the contents of backup_hope to your new location
echo 2. Copy the contents of the storage folder to storage/app/public/
echo 3. Run: php artisan storage:link
echo 4. Import the database
pause
