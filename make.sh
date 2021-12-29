#!/bin/bash
target=${1:-usage}

case ${target} in
    install)
        composer install && php artisan key:generate && php artisan storage:link && php artisan migrate:fresh --seed && cd socket && npm install
    ;;

    *)
        echo "Choose something bitch!"
    ;;
esac
