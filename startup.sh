#!/bin/bash
touch /var/www/html/database/database.sqlite
php /var/www/html/artisan migrate --force --no-interaction
