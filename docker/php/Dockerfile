FROM php:8.4-fpm

WORKDIR /var/www

ARG DOCKER_USER=user
ARG DOCKER_USER_UID=1000

ENV PHP_MEMORY_LIMIT=1024M

RUN apt-get update && apt-get install -y \
    sudo \
    git \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    xsl \
    gd \
    intl \
    opcache \
    exif \
    mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./docker/php/ini/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER root

RUN useradd \
    --uid $DOCKER_USER_UID \
    --groups=www-data,root,sudo \
    --create-home \
    --home-dir=/home/${DOCKER_USER} \
    --shell=/bin/bash \
    ${DOCKER_USER}

RUN echo "${DOCKER_USER} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

RUN chown -R $DOCKER_USER:$DOCKER_USER /var/www

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt install symfony-cli