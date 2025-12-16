@echo off
echo Fixing cache permissions...
takeown /F "bootstrap\cache" /R
icacls "bootstrap\cache" /grant Users:F /T
echo Cache permissions fixed!
pause