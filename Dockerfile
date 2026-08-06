FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

RUN apache2ctl -M

EXPOSE 80

CMD ["apache2-foreground"]