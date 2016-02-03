FROM debian:jessie

RUN apt-get update && apt-get install -y php5-common php5-cli

WORKDIR /var/www/wellfollowed/

RUN php app/console gos:websocket:server

EXPOSE 8080