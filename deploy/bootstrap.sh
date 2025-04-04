#!/bin/bash

set -e

# Copy .env.example if .env doesn't exist
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo ".env file created from example"
else
  echo ".env file already exists"
fi

composer install
npm install

# Generate APP_KEY if missing
if ! grep -q '^APP_KEY=[^[:space:]]' .env; then
    php artisan key:generate
    echo "Generated new APP_KEY"
else
  echo "APP_KEY Already Defined"
fi

php artisan migrate --seed

supervisord -c /etc/supervisor/supervisord.conf
