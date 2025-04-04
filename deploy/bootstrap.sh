#!/bin/bash

set -e



composer install
npm install

if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created from .env.example"
    php artisan key:generate
else
    echo ".env file already exists, skipping copy"
fi

php artisan migrate

supervisord -c /etc/supervisor/supervisord.conf
