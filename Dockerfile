FROM php:8.2-apache

# Enable extensions used by the app (curl, xml).
RUN apt-get update && apt-get install -y --no-install-recommends libcurl4-openssl-dev libxml2-dev \
 && docker-php-ext-install curl xml \
 && apt-get remove -y libcurl4-openssl-dev libxml2-dev \
 && apt-get autoremove -y \
 && rm -rf /var/lib/apt/lists/*

# Allow URL fopen for compatibility, keep errors visible in dev.
RUN sed -i 's/allow_url_fopen = Off/allow_url_fopen = On/' /usr/local/etc/php/php.ini-production \
 && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY . /var/www/html/

# Writable cache dir for the PHP backend.
RUN mkdir -p /var/www/html/cache \
 && chown -R www-data:www-data /var/www/html/cache

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --start-period=10s \
  CMD curl -sf http://localhost/ || exit 1
