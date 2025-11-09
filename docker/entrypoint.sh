#!/bin/sh
set -e

cd /var/www/html

# 1) If no .env present, copy example
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
    echo "[entrypoint] .env created from .env.example"
  else
    echo "[entrypoint] WARNING: no .env.example found, skipping .env creation"
  fi
fi

# 2) If APP_KEY env var is set, ensure .env has it (overwrite or append)
if [ -n "${APP_KEY}" ]; then
  if grep -q '^APP_KEY=' .env 2>/dev/null; then
    # replace existing APP_KEY line safely (works with slashes, pluses, etc.)
    awk -v key="$APP_KEY" 'BEGIN{OFS=ORS=""}
      /^APP_KEY=/ { print "APP_KEY=" key "\n"; next }
      { print $0 "\n" }' .env > .env.tmp && mv .env.tmp .env
  else
    printf "\nAPP_KEY=%s\n" "${APP_KEY}" >> .env
  fi
  echo "[entrypoint] APP_KEY synced into .env"
fi

# 3) Generate key only if APP_KEY missing or empty in .env
if ! grep -q '^APP_KEY=' .env 2>/dev/null || grep -q '^APP_KEY=$' .env 2>/dev/null; then
  php artisan key:generate --ansi --force
  echo "[entrypoint] APP_KEY generated"
fi

# 4) Create storage symlink only if missing
if [ ! -L public/storage ]; then
  php artisan storage:link || true
  echo "[entrypoint] storage:link executed"
else
  echo "[entrypoint] public/storage link exists, skipping"
fi

# 5) Ensure permissions
chown -R www-data:www-data storage bootstrap/cache public/storage || true
chmod -R 775 storage bootstrap/cache public/storage || true

php-fpm -D

# start nginx only if requested (default: false)
if [ "${START_NGINX:-0}" != "0" ]; then
  echo "[entrypoint] starting nginx"
  nginx -g 'daemon off;'
else
  echo "[entrypoint] skipping nginx (START_NGINX not set)"
  # keep container running as php-fpm is already started in background
  tail -f /dev/null
fi

# 6) Exec the container command
exec "$@"
