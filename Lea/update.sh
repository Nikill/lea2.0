#!/usr/bin/env bash

git pull

php bin/console cache:clear
php bin/console cache:clear --env=prod

chmod -R 777 var/cache
chmod -R 777 var/logs
chmod -R 777 var/sessions