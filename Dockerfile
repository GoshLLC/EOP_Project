FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction

ENV WEBROOT=/var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false

CMD ["/start.sh"]
