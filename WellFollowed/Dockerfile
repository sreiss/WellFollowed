FROM php:5.6

VOLUME /var/www/wellfollowed

RUN chown -R www-data:www-data /var/www/wellfollowed

RUN chown -R www-data:www-data /var/www/wellfollowed

RUN usermod -u 1000 www-data

WORKDIR /var/www/wellfollwed

RUN php -r "readfile('https://getcomposer.org/installer');" | php

RUN composer.phar update