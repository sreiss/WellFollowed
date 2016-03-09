#!/usr/bin/env bash
mysql -uroot -e "DROP DATABASE wellfollowed;CREATE DATABASE wellfollowed;GRANT ALL PRIVILEGES ON wellfollowed.* TO 'wellfollowed'@'localhost'"
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load --no-interaction