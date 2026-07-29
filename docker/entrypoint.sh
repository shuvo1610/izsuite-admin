#!/bin/sh
set -e

# Runs on every container start, for app / queue / scheduler alike. The service
# that ends up serving HTTP is decided at the bottom; queue and scheduler
# override the entrypoint entirely in docker-compose.yml, so they never reach
# the migration or cache-warming steps below.

mkdir -p \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    /tmp/composer \
    /var/www/.cache/composer \
    2>/dev/null || true

# In production the container starts as root purely to fix ownership of named
# volumes, which Docker creates owned by root the first time they are mounted.
# Without this a fresh volume makes storage/ unwritable and the app crash-loops.
if [ "$APP_ENV" = "production" ] && [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        /tmp/composer \
        /var/www/.cache/composer \
        /data \
        /config \
        2>/dev/null || true
    chmod -R u+rwX,g+rwX storage bootstrap/cache 2>/dev/null || true

    if command -v git >/dev/null 2>&1; then
        git config --system --add safe.directory /app 2>/dev/null || true
    fi
fi

FAILED=""
for d in storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache; do
    if [ ! -w "$d" ]; then
        FAILED="$FAILED $d"
    fi
done

if [ -n "$FAILED" ]; then
    echo "==> Not writable by $(id -un) (uid=$(id -u)):$FAILED"
    echo "==> Usually a named volume created by an earlier run and still owned by root."
    echo "==> Fix from the host:"
    echo "      docker compose stop app"
    echo "      docker run --rm -v izsuite-api_app-storage:/data alpine sh -c 'chown -R 33:33 /data'"
    echo "      docker compose start app"
    exit 1
fi

run_as_app() {
    if [ "$APP_ENV" = "production" ] && [ "$(id -u)" = "0" ]; then
        gosu www-data "$@"
    else
        "$@"
    fi
}

# APP_KEY has no sane default — an empty one makes every encrypted cookie and
# session fail with an unhelpful error deep in the framework. Fail loudly here
# instead.
if [ -z "$APP_KEY" ] && ! grep -qE '^APP_KEY=base64:' .env 2>/dev/null; then
    echo "==> APP_KEY is not set. Generate one with:"
    echo "      docker compose run --rm app php artisan key:generate --show"
    echo "    then put it in .env and restart."
    exit 1
fi

# Dev only: the production image bakes assets in via the builder stage, so a
# missing manifest there means the build genuinely failed and should not be
# papered over at runtime.
if [ "$APP_ENV" != "production" ]; then
    # node_modules is an anonymous volume in dev. Docker seeds it from the
    # image only when the volume is FIRST created — so a volume left over from
    # a run where the image had no node_modules stays empty forever, and
    # `docker compose up --build` does not fix it because the volume outlives
    # the image. Symptom is `sh: 1: vite: not found` in a restart loop.
    #
    # Test for the binary, not the directory: an empty node_modules still
    # passes `[ -d ]`.
    if [ ! -x node_modules/.bin/vite ] && command -v npm >/dev/null 2>&1; then
        echo "==> node_modules is empty or incomplete (stale volume?) — installing..."
        npm install --no-audit --no-fund || echo "==> WARN: npm install failed"
    fi

    if [ ! -f public/build/manifest.json ]; then
        if [ -x node_modules/.bin/vite ]; then
            echo "==> public/build/manifest.json missing — building assets..."
            npm run build || echo "==> WARN: asset build failed; pages will render unstyled."
        else
            echo "==> WARN: no asset manifest and no node toolchain; pages will render unstyled."
        fi
    fi
fi

echo "==> Refreshing package discovery..."
run_as_app php artisan package:discover --ansi

echo "==> Running migrations..."
run_as_app php artisan migrate --force

# public/storage is gitignored and storage/ is a named volume in production, so
# the symlink cannot be baked into the image — it has to be recreated on every
# boot. Without it each /storage/... URL 404s while the files sit there intact.
# `|| true` because a missing symlink degrades uploads rather than justifying a
# crash loop.
echo "==> Linking public/storage..."
run_as_app php artisan storage:link --force || true

if [ "$APP_ENV" = "production" ]; then
    # Clear first: config:cache on top of a cache built from a previous image's
    # .env silently serves stale values, which is painful to diagnose.
    echo "==> Clearing caches from previous build..."
    run_as_app php artisan optimize:clear

    echo "==> Caching config, events and views..."
    run_as_app php artisan config:cache
    run_as_app php artisan event:cache
    run_as_app php artisan view:cache
fi

if [ "$APP_ENV" = "production" ]; then
    echo "==> Starting Octane (FrankenPHP) on :8000..."
    # Octane keeps the framework booted across requests for far higher
    # throughput than classic one-process-per-request mode. The trade-off is
    # that worker state survives between requests, so anything request-scoped
    # must be flushed per request — config/octane.php wires the standard flush
    # listeners, and the app has no static/container state that leaks.
    #
    # --host=0.0.0.0 is mandatory: Docker's published-port forwarding only
    # reaches the container if the process listens on all interfaces, not
    # loopback. Octane generates its own Caddyfile in storage/, so the classic
    # mode `--config /etc/caddy/Caddyfile` is gone.
    if [ "$(id -u)" = "0" ]; then
        exec gosu www-data php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000
    fi
    exec php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000
else
    echo "==> Starting artisan serve (local — instant reloads, no opcache)..."
    exec php artisan serve --host=0.0.0.0 --port=8000
fi
