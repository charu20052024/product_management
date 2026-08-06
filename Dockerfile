FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

RUN ls -l /etc/apache2/mods-enabled/

EXPOSE 80

CMD ["apache2-foreground"]