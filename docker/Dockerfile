FROM php:8.5-apache-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY apache/jukebox.conf /etc/apache2/sites-available/jukebox.conf
RUN a2dissite 000-default && a2ensite jukebox
#El código se sobreescribe en el compose pero lo mantengo aquí para dejar la imagen funcional de forma independiente
COPY ./src/ /var/www/html/
# COPY data/ /var/www/html/data/
# RUN docker npm install
