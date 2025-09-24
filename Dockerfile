# Imagen base con PHP + Apache
FROM php:8.1-apache

# Copiar todos los archivos del repo al servidor web
COPY . /var/www/html/

# Habilitar extensiones necesarias de PHP (si luego usas DB puedes añadir más)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exponer el puerto 80
EXPOSE 80

# Arrancar Apache en primer plano
CMD ["apache2-foreground"]
