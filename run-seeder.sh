#!/bin/bash

cd /app/src

# Ejecutar migraciones si es necesario
# php artisan migrate

# Ejecutar el seeder
php artisan db:seed

echo "Seeder ejecutado exitosamente!"
