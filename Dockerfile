FROM php:8.3-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

# PHP extension
RUN apt-get update && apt-get install -y gnupg gosu curl ca-certificates zip unzip git \
    && apt-get purge --auto-remove -y \
    #&& curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    #&& apt-get update \
    #&& apt-get install -y nodejs \
    #&& npm install -g npm \
    #&& npm install -g pnpm \
    && apt-get update \
    #&& apt-get install -y yarn \
    #&& apt-get install -y mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Apache & PHP configuration
RUN a2enmod rewrite
ADD docker/apache/vhost.conf /etc/apache2/sites-enabled/000-default.conf
ADD docker/php/php.ini /usr/local/etc/php/php.ini

# Add the application
ADD . /var/www/html/
WORKDIR /var/www/html/

# Install composer
#RUN curl -sS https://getcomposer.org/installer | php \
#    && mv composer.phar /usr/bin/composer

# Install dependencies
#RUN composer install -o

# Ensure that the production container will run with the www-data user
RUN chown www-data /var/www/html/

EXPOSE 80

#CMD ["/var/www/html/docker/apache/run.sh"]
