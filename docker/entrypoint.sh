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

if [ -f /etc/nginx/conf.d/macromate.conf.template ]; then
  echo "[entrypoint] rendering nginx config from template (PORT=${PORT:-80})"
  # remove default site files if present to avoid conflicts
  rm -f /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf.default /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default || true

  # substitute PORT into conf (envsubst is usually present)
  /bin/sh -c "export PORT=${PORT:-80} && envsubst '\$\{PORT:-80\}' < /etc/nginx/conf.d/macromate.conf.template > /etc/nginx/conf.d/macromate.conf" || {
    # fallback: simple sed substitute if envsubst absent
    sed "s/\${PORT:-80}/${PORT:-80}/g" /etc/nginx/conf.d/macromate.conf.template > /etc/nginx/conf.d/macromate.conf || true
  }

  echo "[entrypoint] nginx config rendered at /etc/nginx/conf.d/macromate.conf"
fi

# Start php-fpm (background)
php-fpm -D

# Start nginx only if requested (for compose vs single-container)
if [ "${START_NGINX:-0}" != "0" ]; then
  echo "[entrypoint] starting nginx"
  nginx -g 'daemon off;'
else
  echo "[entrypoint] skipping nginx (START_NGINX not set)"
  # keep container alive so php-fpm stays up (Render normally needs nginx)
  tail -f /dev/null
fi

# 6) Exec the container command
exec "$@"
