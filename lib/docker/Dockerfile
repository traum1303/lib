FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    wget \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pcntl

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

COPY . .

EXPOSE 9000

CMD ["php-fpm"]


