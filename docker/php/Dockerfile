ARG PHP_VERSION
FROM mlocati/php-extension-installer as extension_installer
FROM php:$PHP_VERSION

ARG USER_ID=1001

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=extension_installer /usr/bin/install-php-extensions /usr/bin/

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

RUN docker-php-ext-install intl zip gd gmp pdo pdo_mysql pdo_pgsql pgsql opcache

RUN install-php-extensions xdebug-3.3.2

WORKDIR /app
ADD . /app
