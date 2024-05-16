FROM wordpress:cli-2

USER root

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER www-data

# copy custom php-configuration (max file size + xdebug)
COPY ./php-conf.ini /usr/local/etc/php/conf.d/