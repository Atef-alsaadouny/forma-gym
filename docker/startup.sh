#!/bin/bash

set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force --no-interaction

export APP_KEY=$(grep ^APP_KEY= .env | head -1 | cut -d= -f2-)

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache public/storage

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
