FROM php:8.2-cli-bookworm

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_HOME=/var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        nodejs \
        npm \
        unzip \
        zip \
    && docker-php-ext-install intl mbstring pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR ${APP_HOME}

COPY docker/app-entrypoint.sh /usr/local/bin/app-entrypoint
COPY . .

RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && npm ci --no-audit --no-fund \
    && npm run build \
    && rm -rf node_modules \
    && chmod +x /usr/local/bin/app-entrypoint

CMD ["app-entrypoint"]
