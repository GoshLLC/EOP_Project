FROM richarvey/nginx-php-fpm:3.1.6  # PHP 8.2+ compatible; or use :latest

# Copy your full project
COPY . /var/www/html

# Env vars (required by the image + good for Laravel prod)
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV SKIP_COMPOSER=1  # Set to 0 if you want composer install on every start (slower)

# Laravel production settings
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install deps during build
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

# Cache configs (speeds up app; || true ignores if no DB yet)
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache || true

# Starts Nginx + PHP-FPM
CMD ["/start.sh"]
