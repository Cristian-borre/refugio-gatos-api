# Usar PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias y extensiones PHP para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache para Laravel
COPY laravel.conf /etc/apache2/sites-available/000-default.conf

# Copiar proyecto al contenedor
COPY . /var/www/html

# Cambiar permisos para que Apache pueda leer y escribir donde se necesite
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

# Copiar Composer desde la imagen oficial de composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Exponer puerto 80 (Apache)
EXPOSE 80
