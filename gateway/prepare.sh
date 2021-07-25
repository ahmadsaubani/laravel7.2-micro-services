#!/bin/bash

#before run make sure u add permission to this file : like sudo chmod +x ./prepare.sh

composer dump-autoload
php artisan migrate:fresh
php artisan db:seed
php artisan key:generate
php artisan passport:install