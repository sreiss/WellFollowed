#!/bin/bash

PROGNAME=$(basename $0)

sep() {
    echo "========================================"
}

error() {
    sep
    echo "${PROGNAME}: ${1} ${2:-"Unknown Error"}" 1>&2
    sep
    exit 1
}

install_packages() {
    sep
    echo "Installing required dependencies..."
    sep

    apt-get update

    sep
    echo "Installing RabbitMQ..."
    sep

    local RABBITMQPKG=$(cat /etc/apt/sources.list | grep "deb http://www.rabbitmq.com/debian/ testing main")
    if [ "$RABBITMQPKG" == "" ]
        then echo "deb http://www.rabbitmq.com/debian/ testing main" >> "/etc/apt/sources.list"
    fi

    # RabbitMQ
    wget https://www.rabbitmq.com/rabbitmq-signing-key-public.asc
    apt-key add rabbitmq-signing-key-public.asc
    rm rabbitmq-signing-key-public.asc
    apt-get update
    apt-get install -q -y rabbitmq-server

    # MySQL
    apt-get install  -q -y mysql-server
    #mysql_install_db
    mysql -uroot -e "CREATE USER 'wellfollowed'@'localhost' IDENTIFIED BY 'fpY~Zu5DrJ{}wS={'"
    mysql -uroot -e "CREATE DATABASE wellfollowed"
    mysql -uroot -e "GRANT ALL PRIVILEGES ON wellfollowed.* TO 'wellfollowed'@'localhost'"
    #mysql_secure_installation

    # PHP
    apt-get -q -y install php5-fpm php5-mysql
    service php5-fpm restart

    # Nginx
    apt-get install  -q -y nginx
    NGINXCONF="server {
    listen 8085;
    set \$root_path /var/www/wellfollowed/web;
    root \$root_path;
    server_name localhost;

    location / {
        try_files \$uri @rewriteapp;
    }

    location @rewriteapp {
        rewrite ^(.*)$ /app_dev.php/\$1 last;
    }

    location ~ ^/(app|app_dev|config)\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }
}"

    echo "$NGINXCONF" > /etc/nginx/sites-available/wellfollowed
    rm /etc/nginx/sites-enabled/default
    ln -s /etc/nginx/sites-available/wellfollowed /etc/nginx/sites-enabled/wellfollowed
    service nginx restart

    # Composer
    cp -R WellFollowed /var/www/wellfollowed
    cd /var/www
    mkdir wellfollowed
    cd wellfollowed
    php -r "readfile('https://getcomposer.org/installer');" | php
    php composer.phar install
}

ISROOT=0
for group in $(groups)
do
    if [ "$group" = "root" ]
        then ISROOT=1
    fi
done

if [ $ISROOT = 0 ]
    then error ${LINENO} "Root privileges required to install WellFollowed. run sudo sh ./install.sh."
fi

install_packages

sep
echo "WellFollowed was successfully installed."
sep