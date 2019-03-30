FROM wordpress:4-php7.2-apache

RUN apt-get update &&\
  apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
  rm -rf /var/lib/apt/lists/*

# install xdebug
RUN pecl install -f xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;
