FROM nginx:stable

RUN apt-get update && apt-get install mc -y
COPY vhost.conf /etc/nginx/conf.d/vhost.conf
