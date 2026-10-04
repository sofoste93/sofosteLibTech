#!/usr/bin/env sh
set -eu

if ! command -v php >/dev/null 2>&1; then
  echo "PHP was not found. Install PHP 8.1 or newer and add it to PATH." >&2
  exit 1
fi

echo "Sofoste LibTech is available at http://localhost:8080"
echo "Other devices on this Wi-Fi can use this computer's local IP with port 8080."
php -S 0.0.0.0:8080

