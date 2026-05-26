# ─────────────────────────────────────────────
# Etapa 1: Compilar Angular
# ─────────────────────────────────────────────
FROM node:20-alpine AS angular-build

WORKDIR /app
COPY frontend/package*.json ./
RUN npm ci
COPY frontend/ ./
RUN npm run build -- --configuration production


# ─────────────────────────────────────────────
# Etapa 2: Symfony + Apache + PostgreSQL
# ─────────────────────────────────────────────
FROM php:8.3-apache

# Extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activar mod_rewrite (necesario para .htaccess)
RUN a2enmod rewrite

# Apuntar Apache a Symfony public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

# Permitir .htaccess en el directorio public
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copiar backend Symfony e instalar dependencias
COPY backend/ ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar el build de Angular a Symfony public/
# (así frontend y API quedan en el mismo dominio → /api)
COPY --from=angular-build /app/dist/frontend/browser/ ./public/

# Permisos correctos para Apache y Symfony
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 var/

# Script de arranque (ajusta PORT + inicializa Symfony)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

EXPOSE 80
CMD ["/docker-entrypoint.sh"]
