#!/bin/bash

if [ "$#" -eq 0 ]; then
    echo "⚠ No arguments supplied, using default with --no-cache"
    docker compose exec php ./vendor/bin/phpcs --no-cache
elif [ "$1" == "fix" ]; then
    echo "Applying fixes..."
    docker compose exec php ./vendor/bin/phpcbf
else
    docker compose exec php ./vendor/bin/phpcs "$@"
fi
