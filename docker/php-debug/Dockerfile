FROM scoreya/php
MAINTAINER Alexander Miehe <thelex@beamscore.com>

RUN yum install -y php-pecl-xdebug \
    && yum -y clean all

ADD xdebug.ini /etc/php.d/100-xdebug.ini
ADD xdebug /usr/bin/xdebug
RUN chmod +x /usr/bin/xdebug