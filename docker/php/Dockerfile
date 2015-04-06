FROM ubuntu:14.04.2
MAINTAINER Alexander Miehe <thelex@beamscore.com>
ENV PHP_VERSION 5.6.7
WORKDIR /tmp
RUN echo "deb http://ppa.launchpad.net/ondrej/php5-5.6/ubuntu trusty main" >> /etc/apt/sources.list \
    && echo "deb-src http://ppa.launchpad.net/ondrej/php5-5.6/ubuntu trusty main " >> /etc/apt/sources.list \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv-keys E5267A6C \
    && apt-get update \
    && apt-get install -y curl php5-fpm git php5-intl php5-mongo php-pear php5-dev php5-curl \
    && yes '' | pecl upgrade mongo \
    && sed -i '/^listen = /clisten = 0.0.0.0:9000' /etc/php5/fpm/pool.d/www.conf  \
    && sed -i '/^;catch_workers_output/ccatch_workers_output = yes' /etc/php5/fpm/pool.d/www.conf

ADD php.ini /etc/php5/cli/conf.d/99-custom.ini
ADD php.ini /etc/php5/fpm/conf.d/99-custom.ini

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

VOLUME ["/var/log/php-fpm", "/root/.composer", "/srv/www/app"]
WORKDIR /srv/www/app

RUN usermod -u 500 www-data

EXPOSE 9000

CMD ["php5-fpm", "-F"]
