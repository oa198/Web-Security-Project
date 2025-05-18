@echo off
echo Stopping Apache service...
taskkill /F /IM httpd.exe
echo Starting Apache service...
start "Apache" "C:\xampp\apache\bin\httpd.exe"
echo Apache has been restarted with PHP support.
echo.
echo Please access your sites at:
echo http://project.localhost.com:8080
echo http://project.localhost.com:8080/info.php - to verify PHP is working
echo.
echo If you see the PHP code displaying in your browser instead of executing:
echo 1. Make sure the PHP directory exists at C:\xampp\php
echo 2. Verify php8apache2_4.dll exists in that directory
echo 3. Check the Apache error log for any issues
pause 