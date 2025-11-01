# builder: composer + node build
FROM node:18 AS node-builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources resources
RUN npm ci --no-audit --no-progress
RUN npm run build

FROM composer:2 as composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-interaction --no-progress --optimize-autoloader

# production image
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# system deps
RUN apk add --no-cache bash git icu-dev libpng-dev libjpeg-turbo-dev oniguruma-dev zlib-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring intl gd zip

# copy composer artifacts
COPY --from=composer /app/vendor ./vendor
COPY --from=composer /app/composer.lock ./composer.lock

# copy app code
COPY . .

# copy frontend build into public/build (from node-builder)
COPY --from=node-builder /app/public/build ./public/build

# set permissions (adjust to your setup)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# php-fpm config entrypoint (optional)
CMD ["php-fpm"]
