#!/bin/sh
set -e

cd /var/www/html || exit 1

echo "[entrypoint] starting"

# -------------------------
# 1) Ensure .env exists
# -------------------------
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
    echo "[entrypoint] .env created from .env.example"
  else
    echo "[entrypoint] WARNING: no .env.example found, skipping .env creation"
  fi
fi

# -------------------------
# 2) Sync APP_KEY into .env (safe for slashes and special chars)
# -------------------------
if [ -n "${APP_KEY:-}" ]; then
  if grep -q '^APP_KEY=' .env 2>/dev/null; then
    # Replace APP_KEY line safely via awk to avoid sed delimiter issues
    awk -v key="$APP_KEY" 'BEGIN{OFS=ORS=""}
      /^APP_KEY=/ { print "APP_KEY=" key "\n"; next }
      { print $0 "\n" }' .env > .env.tmp && mv .env.tmp .env
  else
    printf "\nAPP_KEY=%s\n" "${APP_KEY}" >> .env
  fi
  echo "[entrypoint] APP_KEY synced into .env"
fi

# -------------------------
# 3) Generate APP_KEY if missing or empty
# -------------------------
if ! grep -q '^APP_KEY=' .env 2>/dev/null || grep -q '^APP_KEY=$' .env 2>/dev/null; then
  echo "[entrypoint] generating APP_KEY"
  php artisan key:generate --ansi --force || true
fi

# -------------------------
# 4) Write Aiven CA if provided
# -------------------------
if [ -n "${AIVEN_CA:-}" ]; then
  echo "[entrypoint] writing AIVEN CA to /etc/ssl/certs/aiven-ca.pem"
  mkdir -p /etc/ssl/certs
  printf '%s\n' "$AIVEN_CA" > /etc/ssl/certs/aiven-ca.pem
  chmod 644 /etc/ssl/certs/aiven-ca.pem
fi

# -------------------------
# 5) Clear Laravel caches
# -------------------------
echo "[entrypoint] clearing Laravel caches"
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# -------------------------
# 6) Create storage symlink idempotently
# -------------------------
# Use -e so it handles file/symlink/dir absence correctly
if [ ! -e public/storage ]; then
  echo "[entrypoint] creating storage symlink"
  php artisan storage:link || true
else
  echo "[entrypoint] public/storage exists; skipping storage:link"
fi

# -------------------------
# 7) Ensure permissions (best-effort)
# -------------------------
echo "[entrypoint] setting permissions (best-effort)"
chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null || true
chmod -R 775 storage bootstrap/cache public/storage 2>/dev/null || true

# -------------------------
# 8) Render nginx config from template (if present)
# -------------------------
if [ -f /etc/nginx/conf.d/macromate.conf.template ]; then
  echo "[entrypoint] rendering nginx config from template (PORT=${PORT:-80})"

  # remove default site files if present to avoid conflicts
  rm -f /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf.default /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default || true

  # Try envsubst first (clean substitution). If not present, fallback to sed.
  if command -v envsubst >/dev/null 2>&1; then
    # export PORT so envsubst can use it
    export PORT="${PORT:-80}"
    envsubst '\$PORT' < /etc/nginx/conf.d/macromate.conf.template > /etc/nginx/conf.d/macromate.conf || {
      echo "[entrypoint] envsubst failed, falling back to sed"
      sed "s/\${PORT:-80}/${PORT:-80}/g" /etc/nginx/conf.d/macromate.conf.template > /etc/nginx/conf.d/macromate.conf || true
    }
  else
    # no envsubst, use sed fallback
    sed "s/\${PORT:-80}/${PORT:-80}/g" /etc/nginx/conf.d/macromate.conf.template > /etc/nginx/conf.d/macromate.conf || true
  fi

  echo "[entrypoint] nginx config rendered at /etc/nginx/conf.d/macromate.conf"
fi

# -------------------------
# 9) Start services
# -------------------------
echo "[entrypoint] starting php-fpm"
php-fpm -D

# If START_NGINX is set to 1, start nginx in foreground (Render / single-container)
if [ "${START_NGINX:-0}" != "0" ]; then
  echo "[entrypoint] starting nginx (foreground)"
  nginx -g 'daemon off;'
else
  echo "[entrypoint] START_NGINX not set; skipping nginx (compose mode assumed)"
  # Keep container alive so php-fpm stays running when no nginx is desired
  tail -f /dev/null
fi

# Exec fallback (unlikely to be reached because nginx -g 'daemon off;' is foreground)
exec "$@"
