FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       unzip \
       libzip-dev \
       zlib1g-dev \
       libpng-dev \
       libjpeg-dev \
       libfreetype6-dev \
       libonig-dev \
       libxml2-dev \
       libcurl4-openssl-dev \
       pkg-config \
       libssl-dev \
       libpq-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql zip mbstring exif pcntl bcmath gd \
    && pecl install redis || true \
    && docker-php-ext-enable redis || true \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

RUN useradd -m appuser || true

# Pre-install composer dependencies by copying composer files and running install
# This allows Docker to cache the vendor layer
COPY src/composer.json src/composer.lock ./

RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

# Copiar entrypoint script
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
