# Apache and PHP Setup Information

## Current Configuration
- **Web Server**: Apache 
- **PHP**: Version 8.x
- **Port**: 8080
- **Virtual Hosts**:
  - http://project.localhost.com:8080 (Laravel application)
  - http://websec.local.com:8080 (Secondary domain)

## How to Start/Restart the Server
Run `restart_apache_php.bat` to restart Apache with PHP support.

## Testing PHP
Visit http://project.localhost.com:8080/info.php to verify PHP is working correctly.

## Laravel Environment
The `.env` file has been configured to use:
- APP_URL=http://project.localhost.com:8080
- MIX_APP_URL=http://project.localhost.com:8080
- GOOGLE_REDIRECT_URI=http://project.localhost.com:8080/auth/google/callback

## Hosts File Configuration
Make sure your hosts file (C:\Windows\System32\drivers\etc\hosts) contains:
```
127.0.0.1 project.localhost.com
127.0.0.1 websec.local.com
```

## Important Files
- **restart_apache_php.bat**: Script to restart Apache with PHP support
- **info.php**: PHP info page for testing

## Troubleshooting
If you encounter issues:
1. Check Apache error logs at `C:\xampp\apache\logs\error.log`
2. Verify all modules are loaded correctly
3. Ensure port 8080 is not in use by another application 