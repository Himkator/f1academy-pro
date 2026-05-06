#!/bin/bash

# запускаем миграции при каждом старте
php artisan migrate --force

# создаём storage link
php artisan storage:link

# чистим кеш
php artisan config:clear
php artisan cache:clear

# запускаем Apache
apache2-foreground