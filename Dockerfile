# 1) Node build stage (cache-friendly)
FROM node:22 AS node-builder
WORKDIR /app

COPY package*.json vite.config.js ./
RUN npm ci --no-audit --no-progress

COPY resources resources
RUN npm run build

# 2) Base PHP stage: compile extensions & install vendor once (with dev deps for dev image)
FROM php:8.2-fpm-bullseye AS base
WORKDIR /app

# Install build deps (needed to compile PHP extensions)
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
       git \
       unzip \
       build-essential \
       libzip-dev \
       zlib1g-dev \
       libpng-dev \
       libjpeg-dev \
       libwebp-dev \
       libfreetype6-dev \
       libgmp-dev \
       libicu-dev \
       libonig-dev \
       pkg-config \
       ca-certificates \
       nginx \
  && rm -rf /var/lib/apt/lists/*

# Configure & install PHP extensions required by your project (once)
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
  && docker-php-ext-install -j"$(nproc)" pdo pdo_mysql mbstring intl gd zip gmp

# Install composer
RUN php -r "copy('https://getcomposer.org/installer','/tmp/composer-setup.php');" \
  && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && php -r "unlink('/tmp/composer-setup.php');"

# Install PHP dependencies (including dev for dev image), skip scripts here
COPY composer.json composer.lock ./
ARG COMPOSER_FLAGS="--no-interaction --no-progress --optimize-autoloader --no-scripts"
RUN composer install $COMPOSER_FLAGS

# 3) Final runtime image — reuse base (so runtime libs and extensions are present)
FROM base AS final
WORKDIR /var/www/html

# copy vendor (already in /app/vendor in base), and composer.lock
COPY --from=base /app/vendor /var/www/html/vendor
COPY --from=base /app/composer.lock /var/www/html/composer.lock

# copy app source + built frontend
COPY . .
COPY --from=node-builder /app/public/build ./public/build

# Run package discovery now that artisan & vendor exist
RUN php artisan package:discover --ansi

# Ensure storage directories exist and have correct permissions,
# and create public/storage symlink inside the image
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache public/storage \
 && chown -R www-data:www-data storage bootstrap/cache public/storage \
 && chmod -R 775 storage bootstrap/cache public/storage

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
EXPOSE 80
CMD ["php-fpm"]