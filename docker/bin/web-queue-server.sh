#!/bin/bash

echo "run web-queue-server.sh"

source /etc/profile

cd /home/user00/web
cp /home/user00/web/.env.example /home/user00/web/.env
#/usr/local/bin/composer install
#/usr/local/php/bin/php artisan key:generate
#/usr/local/php/bin/php artisan jwt:secret
/usr/local/php/bin/php artisan config:clear
/usr/local/php/bin/php artisan migrate --seed

php-fpm
nginx -g "daemon off;"
