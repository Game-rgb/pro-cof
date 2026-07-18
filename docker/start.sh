#!/bin/bash
php artisan migrate --force
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf