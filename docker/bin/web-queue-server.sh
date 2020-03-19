#!/bin/bash

echo "run web-queue-server.sh"

source /etc/profile

nscd

cd /home/user00/web
sudo -u user00 cp .env.example .env
sudo -u user00 /usr/local/bin/composer install
sudo -u user00 /usr/local/php/bin/php artisan key:generate
sudo -u user00 /usr/local/php/bin/php artisan jwt:secret
sudo -u user00 /usr/local/php/bin/php artisan migrate
sudo -u user00 /usr/local/php/bin/php artisan db:seed
sudo -u user00 /usr/local/php/bin/php artisan optimize



php-fpm
nginx -g "daemon off;"
