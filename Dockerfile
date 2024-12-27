# Usa una imagen base con PHP
FROM php:8.2-apache

# Copia el código fuente del backend al directorio raíz de Apache
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar el servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
