#!/bin/bash

set -e

php artisan package:discover --ansi

php artisan storage:link

if [ -z "${APP_KEY:-}" ]; then
    if [ ! -f .env ]; then
        cp .env.example .env
    fi
    php artisan key:generate --force --no-interaction
    APP_KEY=$(grep ^APP_KEY= .env | head -1 | cut -d= -f2-)
    export APP_KEY
    echo "env[APP_KEY] = ${APP_KEY}" >> /usr/local/etc/php-fpm.d/www.conf
fi

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache public/storage

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
