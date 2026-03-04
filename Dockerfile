FROM richarvey/nginx-php-fpm:3.1.6  # PHP 8.2+ compatible; or use :latest

COPY . /var/www/html

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV SKIP_COMPOSER=1  # Set to 0 if you want composer install on every start (slower)

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache || true

CMD ["/start.sh"]
