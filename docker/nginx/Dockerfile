FROM fedora:20
MAINTAINER Alexander Miehe <thelex@beamscore.com>
ENV NGINX_VERSION 1.7.9

RUN yum install -y gcc pcre pcre-devel openssl-devel make \
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
    && echo "clean_requirements_on_remove=1" >> /etc/yum.conf \
    && yum remove -y gcc make \
    && yum -y clean all

VOLUME ["/var/www", "/var/log/nginx", "/opt/nginx/conf/nginx.conf", "/opt/nginx/certs"]

EXPOSE 80:80 443:443

CMD ["/opt/nginx/sbin/nginx"]
