FROM node:22-bookworm-slim AS player-deps
WORKDIR /app/PracticaJS/Practica2
COPY src/PracticaJS/Practica2/package.json src/PracticaJS/Practica2/package-lock.json ./
RUN npm ci

FROM php:8.5-apache-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev $PHPIZE_DEPS \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && printf '%s\n' \
        'xdebug.mode=debug' \
        'xdebug.start_with_request=yes' \
        'xdebug.client_host=host.docker.internal' \
        'xdebug.client_port=9003' \
        > "$PHP_INI_DIR/conf.d/99-xdebug.ini" \
    && rm -rf /var/lib/apt/lists/*

COPY /docker/apache/jukebox.conf /etc/apache2/sites-available/jukebox.conf
RUN a2dissite 000-default && a2ensite jukebox
# Copiamos desde la raíz porque el binding del compose iba muy lento pero no quiero copiar src y duplicar código
COPY /src/ /var/www/html/
COPY /data/ /var/www/data/
COPY --from=player-deps /app/PracticaJS/Practica2/node_modules/ /var/www/html/PracticaJS/Practica2/node_modules/
