#!/bin/sh
set -e

php artisan key:generate --force || true
php artisan storage:link || true

if [ "${AUTO_MIGRATE:-}" = "1" ]; then
  php artisan migrate --force
fi

chown -R www-data:www-data storage bootstrap/cache || true

exec "$@"
