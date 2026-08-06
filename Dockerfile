FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

CMD ["bash", "-c", "ls -R /etc/apache2 && cat /etc/apache2/apache2.conf && apache2ctl -M && sleep 600"]