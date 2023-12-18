FROM php:7.2.34-apache

RUN apt-get update
RUN apt-get install -y libzip-dev zip cron
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

COPY  ${project_root}/docker/conf/000-default.conf /etc/apache2/sites-enabled/
RUN a2enmod rewrite
RUN a2enmod headers

# Copy .env
COPY .env /var/www/html/.env

# INSTALL COMPOSER
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

CMD /usr/sbin/apache2ctl -D FOREGROUND

CMD ./docker/apache-endpoint.sh
