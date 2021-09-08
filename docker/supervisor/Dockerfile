FROM php:7.3

COPY ./laravel/ /var/www/laravel/
WORKDIR /var/www/laravel

RUN apt update && apt-get install -y supervisor \
  && docker-php-ext-install pdo_mysql

COPY ./docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./docker/supervisor/conf.d/application.conf /etc/supervisor/conf.d/application.conf

CMD ["/usr/bin/supervisord"]