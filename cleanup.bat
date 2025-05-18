@echo off
echo Creating cleanup directory...
mkdir cleanup 2>nul

echo Moving config files to cleanup directory...
move *.conf cleanup\
move *.txt cleanup\
move project_index.php cleanup\
move project_index2.php cleanup\
move websec_index.php cleanup\

echo Moving batch files to cleanup directory...
move start_apache.bat cleanup\
move restart_apache.bat cleanup\

echo Keeping only important files...
echo restart_apache_php.bat - Use this to restart Apache with PHP support
echo info.php - Use this to verify PHP is working

echo.
echo Cleanup complete! All temporary files have been moved to the 'cleanup' folder.
echo If you need any of these files back, you can find them there.
echo.
pause 