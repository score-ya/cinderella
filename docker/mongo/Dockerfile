FROM fedora:20
MAINTAINER Alexander Miehe <thelex@beamscore.com>
# add our user and group first to make sure their IDs get assigned consistently, regardless of whatever dependencies get added
RUN groupadd -r mongodb && useradd -r -g mongodb mongodb

ENV MONGO_VERSION 2.6.6

RUN yum install -y gpg \
	&& yum -y clean all \
	&& gpg --keyserver pgp.mit.edu --recv-keys DFFA3DCF326E302C4787673A01C4E7FAAAB2461C \
	&& curl -SL "https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-$MONGO_VERSION.tgz" -o mongo.tgz \
	&& curl -SL "https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-$MONGO_VERSION.tgz.sig" -o mongo.tgz.sig \
	&& gpg --verify mongo.tgz.sig \
	&& tar -xvf mongo.tgz -C /usr/local --strip-components=1 \
	&& rm mongo.tgz*

VOLUME /data/db

EXPOSE 27017 28017
CMD ["mongod", "-f", "/mongodb.conf"]