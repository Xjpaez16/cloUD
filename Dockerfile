# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copia todos los archivos de tu app al contenedor
COPY . /var/www/html/

# Habilita mod_rewrite (si lo usas en .htaccess, muy común en Laravel, etc.)
RUN a2enmod rewrite

# Configura permisos y trabaja desde el directorio raíz de Apache
WORKDIR /var/www/html

# Expone el puerto por defecto de Apache
EXPOSE 80
