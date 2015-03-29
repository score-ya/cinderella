FROM ubuntu:14.04.2
MAINTAINER Alexander Miehe <thelex@beamscore.com>

ENV MONGO_VERSION 2.6.9

RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10 \
	&& echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' | tee /etc/apt/sources.list.d/mongodb.list \
	&& apt-get update \
	&& apt-get install -y mongodb-org=${MONGO_VERSION} mongodb-org-server=${MONGO_VERSION} mongodb-org-shell=${MONGO_VERSION} mongodb-org-mongos=${MONGO_VERSION} mongodb-org-tools=${MONGO_VERSION}

VOLUME /data/db

EXPOSE 27017 28017
CMD ["mongod", "-f", "/etc/mongod.conf"]