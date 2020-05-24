FROM php:fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apk --update --no-cache add git icu-dev yarn \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j2 intl

RUN docker-php-ext-install pdo_mysql opcache

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer global require "phpunit/phpunit" \
    && export PATH=$PATH:/root/.composer/vendor/bin \
    && ln -s /root/.composer/vendor/bin/phpunit /usr/bin/phpunit

WORKDIR /var/www

CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ; php-fpm

EXPOSE 9000
