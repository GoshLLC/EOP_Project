FROM richarvey/nginx-php-fpm:3.1.6

COPY . /var/www/html

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV SKIP_COMPOSER=1

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache || true

COPY nginx-site.conf /etc/nginx/sites-available/default.conf

CMD ["/bin/sh", "-c", "echo '=== SOCKET FILES ===' && ls -la /run /var/run /run/php* /var/run/php* 2>/dev/null | grep sock || echo 'No .sock files found' && echo '=== PHP-FPM LISTEN CONFIG ===' && grep -Ri 'listen =' /usr/local/etc/php-fpm* /etc/php* 2>/dev/null || echo 'No listen config found' && exec /start.sh"]
#RUN ln -sf /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf || true

CMD ["/start.sh"]
