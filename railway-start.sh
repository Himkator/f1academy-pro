#!/bin/bash

# wait a moment for DB to be ready
sleep 3

# run migrations
php artisan migrate --force

# seed only if needed (comment out after first deploy)
# php artisan db:seed --force

# storage link
php artisan storage:link

# clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# start Apache
apache2-foreground