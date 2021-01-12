FROM wordpress:5-php7.4-apache

RUN apt-get update &&\
  apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
  rm -rf /var/lib/apt/lists/*

# install xdebug
RUN pecl install -f xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;

# enable xdebug profiling:
# RUN echo "xdebug.profiler_enable = 1 \nxdebug.profiler_output_name = xdebug.out.%t \nxdebug.profiler_output_dir = /var/www/html" >> /usr/local/etc/php/conf.d/xdebug.ini;

COPY ./php-conf.ini /usr/local/etc/php/conf.d/