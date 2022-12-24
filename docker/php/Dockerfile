FROM php:8.2-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        mc \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        wget \
        git \
        && docker-php-ext-install zip intl mbstring pdo_mysql exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN usermod -u 1000 www-data

VOLUME /root/.composer
WORKDIR /app

EXPOSE 9000
CMD bash -c "composer install && php-fpm"

#CMD ["php-fpm"]
