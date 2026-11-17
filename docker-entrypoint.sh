#!/bin/sh
set -e

if [ -z "$APP_KEY" ]; then
    if [ ! -s storage/app.key ]; then
        php artisan key:generate --show > storage/app.key
    fi

    APP_KEY="$(cat storage/app.key)"
    export APP_KEY
fi

php artisan migrate --force

exec "$@"
