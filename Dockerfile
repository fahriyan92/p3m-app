FROM php:8.0-apache
WORKDIR /var/www/html
RUN apt-get update -y && apt-get install -y \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libzip-dev \ 
    g++ 


RUN docker-php-ext-install \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    mysqli \
    gd \ 
    zip 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/000-default.conf  /etc/apache2/sites-available/000-default.conf
#/etc/apache2/sites-available/000-default.conf
#RUN MV ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
#RUN echo "ServerName 172.18.0.2" >> /etc/apache2/apache2.conf
#RUN echo 'ServerName 127.0.0.1' >> /etc/apache2/apache2.conf
#RUN service apache2 restart
WORKDIR /var/www/html/
COPY ./composer.json .

RUN useradd -G www-data,root -u 1000 -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

RUN  composer install 
#--ignore-platform-reqs