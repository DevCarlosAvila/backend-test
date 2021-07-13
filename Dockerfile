FROM php:7.4-apache

RUN apt-get update && apt-get install -y git zip unzip libzip-dev
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
&& curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
&& php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
&& php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot \
&& rm -f /tmp/composer-setup.*

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

COPY . /home/devuser/backed-test
WORKDIR /home/devuser/backed-test

RUN cd /home/devuser/backed-test && \
    composer install --prefer-dist

RUN vendor/bin/phpunit
RUN vendor/bin/phpstan analyse src tests
RUN vendor/bin/psalm



