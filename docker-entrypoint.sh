#!/bin/sh
mkdir -p /data
touch /data/database.sqlite
php /var/www/html/artisan migrate --force
exec /entrypoint "$@"
