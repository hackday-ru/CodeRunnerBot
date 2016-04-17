#!/bin/bash

echo "upstream php-upstream { server $PHP_HOST:9000; }" > /etc/nginx/conf.d/upstream.conf

sed -i -e "s/NGINX_HOST/$NGINX_HOST_TEMPLATE/g" /etc/nginx/sites-available/coderunner.conf

cat /etc/nginx/sites-available/coderunner.conf

nginx -g "daemon off;"
