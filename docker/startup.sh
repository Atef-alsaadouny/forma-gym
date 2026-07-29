#!/bin/bash

php artisan key:generate --force --no-interaction

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache public/storage

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
