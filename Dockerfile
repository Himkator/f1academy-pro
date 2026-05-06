FROM php:8.2-apache

# ── СИСТЕМНЫЕ ЗАВИСИМОСТИ ──
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ── PHP РАСШИРЕНИЯ ──
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# ── COMPOSER ──
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ── APACHE MOD_REWRITE ──
RUN a2enmod rewrite

# ── APACHE DOCUMENT ROOT → Laravel public ──
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# ── РАБОЧАЯ ДИРЕКТОРИЯ ──
WORKDIR /var/www/html

# ── КОПИРУЕМ ФАЙЛЫ ──
COPY . .

# ── СОЗДАЁМ .env ИЗ ПЕРЕМЕННЫХ RENDER ──
# Render сам передаст переменные окружения
RUN cp .env.example .env

# ── УСТАНАВЛИВАЕМ ЗАВИСИМОСТИ ──
RUN composer install --no-interaction --optimize-autoloader --no-dev

# ── ГЕНЕРИРУЕМ APP KEY ──
RUN php artisan key:generate

# ── ПРАВА ДОСТУПА ──
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ── СКРИПТ ЗАПУСКА ──
COPY render-start.sh /render-start.sh
RUN chmod +x /render-start.sh

EXPOSE 80

CMD ["/render-start.sh"]