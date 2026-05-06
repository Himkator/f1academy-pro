FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev \
    libxml2-dev libpq-dev zip unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo pdo_pgsql pgsql \
    mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --ignore-platform-reqs \
    --prefer-dist

COPY . .

RUN cp .env.example .env

RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

RUN php artisan key:generate --force

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

COPY railway-start.sh /railway-start.sh
RUN chmod +x /railway-start.sh

EXPOSE 80

CMD ["/railway-start.sh"]