ARG PHP_VERSION
FROM php:$PHP_VERSION

WORKDIR /app

COPY . .

ARG USER_ID=1000
RUN chown -R www-data:www-data /app
RUN usermod -o -u ${USER_ID} -g www-data www-data

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update && apt install -y \
    libzip-dev \
    unzip \
    libpq-dev \
    git \
    libgmp-dev \
    libicu-dev

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-configure intl

RUN docker-php-ext-install intl zip gd gmp pdo pdo_mysql pdo_pgsql pgsql
