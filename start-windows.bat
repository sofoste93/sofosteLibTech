@echo off
where php >nul 2>nul
if errorlevel 1 (
  echo PHP was not found. Install PHP 8.1 or newer and add it to PATH.
  pause
  exit /b 1
)
echo Sofoste LibTech is available at http://localhost:8080
echo Other devices on this Wi-Fi can use this computer's local IP with port 8080.
php -S 0.0.0.0:8080

