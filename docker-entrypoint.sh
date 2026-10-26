#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    key_file="storage/framework/.docker-app-key"

    if [ -s "$key_file" ]; then
        APP_KEY="$(cat "$key_file")"
    else
        APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
        printf '%s' "$APP_KEY" > "$key_file"
    fi

    export APP_KEY
fi

php artisan migrate --force

exec "$@"
