#!/bin/bash
set -e

chmod -R 777 ./storage
# Установить зависимости Composer
composer update

# Пересоздать кэш
php artisan optimize
#php artisan cache:clear
php artisan route:cache
php artisan view:clear
php artisan config:cache

# Перезагрузка очередей
php artisan queue:restart


supervisorctl update
supervisorctl restart all

npm install --legacy-peer-deps
npm run prod
