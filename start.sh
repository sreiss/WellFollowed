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
    
    echo "Starting RabbitMQ..."
    
    rabbitmq-server -detached 2>/dev/null
    
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