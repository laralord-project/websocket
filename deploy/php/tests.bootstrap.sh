#!/usr/bin/bash

set -e
echo "Composer install"
composer install --no-progress
cp .env.testing .env
echo "Run migrations"
php artisan migrate:fresh --seed
echo "Migration completed"

echo "Test execution start"
php artisan test
