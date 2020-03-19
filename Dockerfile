FROM hkccr.ccs.tencentyun.com/yumancang/php_nginx_redis_base

MAINTAINER laifaluo@126.com

WORKDIR /home/user00/

ADD ./ /home/user00/web/
ADD ./docker/nginx.conf /etc/nginx/
ADD ./docker/blog-backend.conf /etc/nginx/conf.d/
ADD ./docker/bin/*.sh ./

RUN chown -R user00:user00 ./
RUN chmod 774 ./*.sh

#启动服务
ENTRYPOINT /bin/bash /home/user00/web-queue-server.sh


#docker build -t yumancang/blog_backend .
#docker run -itd --name=blog_backend -p 81:81 -p 9000:9000 -p 6379:6379 yumancang/blog_backend /bin/sh
