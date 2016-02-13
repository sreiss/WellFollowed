#!/bin/bash

PROGNAME=$(basename $0)
CURRENT_PACKAGE=""
INSTALLED=0
END_MESSAGES=""

sep() {
    echo "========================================"
}

error() {
    sep
    echo "${PROGNAME}: ${1} ${2:-"Unknown Error"}" 1>&2
    sep
    exit 1
}

is_package_installed() {
    INSTALLED=0
    local _INSTALLED=$(dpkg-query -W -f '${Status}' "$CURRENT_PACKAGE")
    if [ "$_INSTALLED" = "install ok installed" ]
        then INSTALLED=1
    fi
}

install_rabbitmq() {
    CURRENT_PACKAGE="rabbitmq-server"
    is_package_installed
    
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing RabbitMQ..."
            sep
            
            local RABBITMQPKG=$(cat /etc/apt/sources.list | grep "deb http\:\/\/www\.rabbitmq\.com\/debian\/ testing main")
            if [ "$RABBITMQPKG" == "" ]
                then echo "deb http://www.rabbitmq.com/debian/ testing main" >> "/etc/apt/sources.list"
            fi
            
            wget https://www.rabbitmq.com/rabbitmq-signing-key-public.asc
            apt-key add rabbitmq-signing-key-public.asc
            rm rabbitmq-signing-key-public.asc
            apt-get update
            apt-get install -q -y rabbitmq-server
       else
            sep
            echo "RabbitMQ is already installed."
            sep
    fi
}

install_mysql() {
    CURRENT_PACKAGE="mysql-server"
    is_package_installed
    
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing MySQL..."
            sep
            
            apt-get install  -q -y mysql-server
            mysql_install_db
            mysql -uroot -e "CREATE USER 'wellfollowed'@'localhost' IDENTIFIED BY 'fpY~Zu5DrJ{}wS={'"
            mysql -uroot -e "CREATE DATABASE wellfollowed"
            mysql -uroot -e "GRANT ALL PRIVILEGES ON wellfollowed.* TO 'wellfollowed'@'localhost'"
            mysql_secure_installation
        else
            sep
            echo "MySQL is already installed."
            sep
            END_MESSAGES="
    $END_MESSAGES
    $(sep)
    MySQL was already installed.
    Please make sure you created a user 'wellfollowed'@'localhost' and a 'wellfollowed' database.
    Execute these commands if not so (replace {wellfollowed_password} by a secure password you generated) :

    CREATE USER 'wellfollowed'@'localhost' IDENTIFIED BY '{wellfollowed_password}'
    CREATE DATABASE wellfollowed
    GRANT ALL PRIVILEGES ON wellfollowed.* TO 'wellfollowed'@'localhost'

    Then, make sur to put {wellfollowed_password} in /var/www/wellfollowed/app/config/parameters.yml and /var/www/wellfollowed/app/config/parameters.yml.dist, in the field 'database_password'
    $(sep)
                "
    fi
}

install_php() {
    CURRENT_PACKAGE="php5-fpm"
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing PHP-FPM"
            sep
            
            apt-get -q -y install php5-fpm > /dev/null
        else
            sep
            echo "PHP-FPM is already installed."
            sep
    fi
    
    CURRENT_PACKAGE="php5-mysql"
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing PHP-MySQL"
            sep
            
            apt-get -q -y install php5-mysql > /dev/null
        else
            sep
            echo "PHP-MySQL is already installed."
            sep
    fi
    
    CURRENT_PACKAGE="php5-cli"
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing PHP-MySQL"
            sep
            
            apt-get -q -y install php5-cli > /dev/null
        else
            sep
            echo "PHP-CLI is already installed."
            sep
    fi
    
    sep
    echo "Restarting PHP service..."
    sep
    
    service php5-fpm restart
}

install_nginx() {
    CURRENT_PACKAGE="nginx"
    is_package_installed
    
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing Nginx"
            sep
    
            apt-get install  -q -y nginx > /dev/null
        else
            sep
            echo "Nginx is already installed."
            sep
    fi
    
    sep
    echo "Configuring Nginx."
    sep
    
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
    
    read -p "Nginx default configuration was found, probably running on port 80, do you wish to turn it off 
    (if not, wellfollowed will not be activated, but instructions will be given at the end of the installation)? (Y|n)" -n 1 -r
    echo
    if [[ $REPLY =~ ^[Nn]$ ]]
        then
            END_MESSAGES="
    $END_MESSAGES
    $(sep)
    You did not accept to turn off Nginx default configuration.
    Please, open /etc/nginx/sites-available/wellfollowed and update the 'listen' directive with a free port and
    create a symlink for the wellfollowed configuration from sites-available to sites-enabled with the following command:
    ln -s /etc/nginx/sites-available/wellfollowed /etc/nginx/sites-enabled/wellfollowed
    Then run 'sudo service nginx restart'.
    $(sep)
    "
        else
            rm /etc/nginx/sites-enabled/default
            ln -s /etc/nginx/sites-available/wellfollowed /etc/nginx/sites-enabled/wellfollowed
    fi
    
    sep
    echo "Restarting Nginx..."
    sep
    #sed -i.bak "s/user\ www\-data;/user\ $USER;/g" /etc/nginx/nginx.conf
    service nginx restart
}

install_node_npm() {
    CURRENT_PACKAGE="nodejs"
    is_package_installed
    
    if [ $INSTALLED = 0 ]
        then
            sep
            echo "Installing Node and Npm..."
            sep
            
            apt-get install curl > /dev/null
            curl -sL https://deb.nodesource.com/setup_5.x | bash -
            apt-get install --yes nodejs > /dev/null
        else
            sep
            echo "Nodejs is already installed."
            sep
    fi
    
    ln -s /usr/bin/nodejs /usr/bin/node
}

install_composer() {
    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
    php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '781c98992e23d4a5ce559daf0170f8a9b3b91331ddc4a3fa9f7d42b6d981513cdc1411730112495fbf9d59cffbf20fb2') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); }"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
}

install_wellfollowed() {
    sep
    echo "Installing WellFollowed..."
    sep
    
    echo "Removing any old file..."
    rm -r /var/www/wellfollowed
    
    echo "Copying sources..."
    cp -R ./WellFollowed /var/www/wellfollowed
    
    echo "Grantings rights to www-data..."
    chown -R www-data:www-data /var/www
 
    cd /var/www/wellfollowed
    
    echo "Installing composer..."
    install_composer
    
    echo "Running composer..."
    sudo -u www-data php composer.phar install
    
    echo "Installing gulp and bower..."
    npm install -g gulp > /dev/null
    npm install -g bower > /dev/null
    
    echo "Installing client dependencies..."    
    npm install > /dev/null
    sudo -u www-data bower install > /dev/null
    
    echo "Running gulp tasks..."
    gulp bowerAssetic > /dev/null
    gulp assetic > /dev/null
}

install_packages() {
    sep
    echo "Installing required dependencies..."
    sep
    
    apt-get update > /dev/null
    
    install_rabbitmq
    
    install_mysql
    
    install_php
    
    install_nginx
    
    install_node_npm
    
    install_wellfollowed
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

echo "$END_MESSAGES"

sep
echo "WellFollowed was successfully installed."
sep