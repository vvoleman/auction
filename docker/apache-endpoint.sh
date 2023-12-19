#!/usr/bin/env bash

docker/wait-for-it.sh mysql:3306 -t 30

# Run migrations
composer update --no-interaction --no-progress --no-suggest && \
php artisan key:generate

echo "Setup is done!"

apache2-foreground
