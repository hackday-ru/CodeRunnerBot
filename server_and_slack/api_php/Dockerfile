FROM php:7.0.5-fpm
MAINTAINER Gregory Vorozhtcov

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-enable pdo
RUN docker-php-ext-enable pdo_mysql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        curl \
        git

RUN apt-get install -y \
    libcurl4-gnutls-dev \
    libc-client-dev

RUN docker-php-ext-install json
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-install iconv
RUN docker-php-ext-install phar

RUN apt-get install -y libtool autoconf automake gcc pkg-config make curl
RUN apt-get install -y net-tools

RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini
RUN echo "date.timezone = UTC" >> /usr/local/etc/php.ini

RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip

RUN php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
RUN php composer-setup.php
RUN mv composer.phar /bin/composer
RUN chmod a+x /bin/composer
RUN php -r "unlink('composer-setup.php');"
RUN curl -o /bin/phpcs https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
RUN chmod a+x /bin/phpcs
RUN apt-get update && apt-get install -y wget
RUN wget -qO- https://get.docker.com/ | sh
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 9000
