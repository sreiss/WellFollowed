#!/bin/sh

gulp bowerAssetic
gulp assetic
gulp &
echo "kill $!" > kill.sh
php app/console gos:websocket:server &
echo "kill $!" >> kill.sh
hhvm --mode server -vServer.Type=fastcgi -vServer.Port=9001 &
echo "kill $!" >> kill.sh
chmod 755 kill.sh