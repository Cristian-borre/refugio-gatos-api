# Usar PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias del sistema y extensiones de PHP
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

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar solo los archivos necesarios para instalar dependencias primero
COPY composer.json composer.lock /var/www/html/

# Instalar dependencias de PHP (Laravel)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Ahora copiar todo el código del proyecto
COPY . /var/www/html

# Cambiar permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer puerto 80
EXPOSE 80
