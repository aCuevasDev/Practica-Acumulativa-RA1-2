# FROM php:8.5-apache-bookworm

# RUN apt-get update \
#     && apt-get install -y --no-install-recommends libpq-dev \
#     && docker-php-ext-install pdo_mysql pdo_pgsql \
#     && rm -rf /var/lib/apt/lists/*

# COPY apache/jukebox.conf /etc/apache2/sites-available/jukebox.conf
# RUN a2dissite 000-default && a2ensite jukebox
#El código se sobreescribe en el compose
# COPY /src/ /var/www/html/
# COPY data/ /var/www/html/data/
# RUN docker npm install


# Uso el de raíz porque no me gustaba duplicar código como pide la práctica y el mapeo de rutas del compose causa lentitud en el servidor