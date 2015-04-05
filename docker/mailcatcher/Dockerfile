FROM ubuntu:14.04.2
MAINTAINER Alexander Miehe <thelex@beamscore.com>

RUN apt-get update \
    && apt-get install -y ruby ruby-dev libsqlite3-dev build-essential \
    && gem install mailcatcher --no-rdoc --no-ri \
    && apt-get remove -y build-essential \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists

EXPOSE 1080 1025
CMD ["mailcatcher", "-fv", "--ip=0.0.0.0"]