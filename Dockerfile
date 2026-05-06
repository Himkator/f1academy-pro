FROM php:8.2-cli

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www

# Копируем composer сначала (для кеша)
COPY composer.json composer.lock ./

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Копируем весь проект
COPY . .

# Laravel оптимизация
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true

RUN php artisan config:cache || true
RUN php artisan route:cache || true

# Порт для Render
EXPOSE 10000

# Запуск
CMD php artisan serve --host=0.0.0.0 --port=10000