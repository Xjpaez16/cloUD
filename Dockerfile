# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copia todos los archivos de tu app al contenedor
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN mkdir -p /var/lib/php/sessions && chown -R www-data:www-data /var/lib/php/sessions
ENV PHP_SESSION_DIR=/var/lib/php/sessions

# Habilita mod_rewrite (si lo usas en .htaccess, muy común en Laravel, etc.)
RUN a2enmod rewrite

# Configura permisos y trabaja desde el directorio raíz de Apache
WORKDIR /var/www/html

# Expone el puerto por defecto de Apache
EXPOSE 80
