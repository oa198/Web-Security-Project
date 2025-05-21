@echo off
echo Stopping Apache service...
taskkill /F /IM httpd.exe
echo Starting Apache service...
start "Apache" "C:\xampp\apache\bin\httpd.exe"
echo Apache has been restarted.
echo.
echo Please access your sites at:
echo http://project.localhost.com:8080
echo http://websec.local.com:8080
pause