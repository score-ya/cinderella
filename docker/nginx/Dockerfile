FROM ubuntu:14.04.1
MAINTAINER Alexander Miehe <thelex@beamscore.com>
ENV NGINX_VERSION 1.7.9

RUN apt-get update \
    && apt-get install -y curl gcc libpcre3-dev libssl-dev make \
    && mkdir -p /tmp/nginx \
    && cd /tmp/nginx \
    && curl -O http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz \
    && tar -zxvf nginx-${NGINX_VERSION}.tar.gz \
    && rm -f nginx-${NGINX_VERSION}.tar.gz \
    && mkdir -p /opt/nginx \
    && cd /tmp/nginx/nginx-${NGINX_VERSION} \
    && ./configure --with-ipv6 --with-http_stub_status_module --with-http_ssl_module --with-http_spdy_module --prefix=/opt/nginx \
    && make \
    && make install \
    && rm -rf /tmp/nginx \
    && apt-get remove -y gcc make \
    && apt-get -y autoremove

VOLUME ["/srv/www/app", "/var/log/nginx", "/opt/nginx/conf/nginx.conf", "/opt/nginx/certs"]

EXPOSE 80:80 443:443

CMD ["/opt/nginx/sbin/nginx"]
