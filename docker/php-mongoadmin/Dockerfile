FROM scoreya/php
MAINTAINER Alexander Miehe <alexander.miehe@gmail.com>

ENV ROCKMONGO_VERSION 1.1.7

RUN mkdir -p /opt/rockmongo \
    && cd /opt/rockmongo \
    && curl -L -O https://github.com/iwind/rockmongo/archive/${ROCKMONGO_VERSION}.tar.gz \
    && tar -zxvf ${ROCKMONGO_VERSION}.tar.gz -C $(pwd) --strip-components=1 \
    && rm -f ${ROCKMONGO_VERSION}.tar.gz

WORKDIR /opt/rockmongo
RUN rm -f config.php && ln -fs /opt/config.php config.php

VOLUME ["/opt/rockmongo"]