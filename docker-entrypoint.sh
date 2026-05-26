#!/bin/bash
set -e

# Render asigna el puerto en $PORT en tiempo de ejecución
PORT=${PORT:-80}
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf

cd /var/www/html

# Limpiar y regenerar caché de Symfony en producción
php bin/console cache:clear --env=prod --no-debug

# Crear/actualizar tablas en PostgreSQL según las entidades Doctrine
# (idempotente: si ya existen, solo añade lo que falte)
php bin/console doctrine:schema:update --force --env=prod

exec apache2-foreground
