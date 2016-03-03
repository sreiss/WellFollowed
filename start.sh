#!/bin/sh

sep() {
    echo "========================================"
}

error() {
    sep
    echo "${PROGNAME}: ${1} ${2:-"Unknown Error"}" 1>&2
    sep
    exit 1
}

run_rabbitmq() {
    
    if [ ! -f /var/run/rabbitmq/pid ];
        then
            echo "Starting RabbitMQ Server..."
            rabbitmq-server -detached 2>/dev/null
        else
            echo "RabbitMQ already running."
    fi

}

run_gos_websocket() {
    
    if [ ! -f /var/run/gos-websocket.pid ];
        then
            echo "Starting Gos Websocket Server..."
            php app/console gos:websocket:server >/dev/null 2>/dev/null &
            echo $! > /var/run/gos-websocket.pid
        else
            echo "Gos Websocket already running."
    fi
    
}

run_mysql() {
    
    if [ ! -f /var/run/mysqld/mysqld.pid ];
        then
            echo "Starting MySQL Server..."
            service mysql start
        else
            echo "MySQL already running."
    fi
    
}

run_nginx() {
    
    if [ ! -f /var/run/nginx.pid ];
        then
            echo "Starting Nginx..."
            service nginx start
        else
            echo "Nginx already running."
    fi
    
}

run_php_fpm() {
    
    if [ ! -f /var/run/php5-fpm.pid ];
        then
            echo "Starting PHP-FPM..."
            service php5-fpm start
        else
            echo "PHP-FPM already running."
    fi
    
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

echo "Starting WellFollowed..."

run_rabbitmq

run_gos_websocket

run_mysql

run_nginx

run_php_fpm