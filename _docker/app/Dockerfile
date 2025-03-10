FROM php:8.2.8-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    supervisor \
    ffmpeg \
    zip unzip \
    git && \
    apt-get install -y libxml2-dev && docker-php-ext-install soap &&\
    docker-php-ext-install pdo_pgsql pdo pdo_pgsql pgsql zip exif pcntl calendar && \
    docker-php-ext-configure pgsql && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install gd && \
    docker-php-ext-install zip && \
    docker-php-ext-install sockets && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install bcmath

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_docker/supervisor/supervisord.conf /etc/supervisor
COPY ./_docker/supervisor/conf.d/default.conf /etc/supervisor/conf.d
COPY ./_docker/supervisor/conf.d/mailing.conf /etc/supervisor/conf.d

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN apt-get install -y tzdata
ENV TZ=Europe/Moscow

RUN pecl install redis \
    && docker-php-ext-enable redis

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN chmod +x /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

# Монтируем .env как том (рекомендуется)
# COPY .env .  # <--- ЗАКОММЕНТИРУЙТЕ или УДАЛИТЕ эту строку, если монтируете .env как том

# ... (другие инструкции, если есть)

CMD ["/usr/bin/supervisord",  "-c",  "/etc/supervisor/supervisord.conf"]
USER root
