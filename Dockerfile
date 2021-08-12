FROM chialab/php:8.0-fpm

ARG PRODUCTION=
ARG COMPOSER_ARGS=

ENV DEBIAN_FRONTEND noninteractive
ENV APT_DEPS supervisor nginx-extras curl default-mysql-client gpg unzip
ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH
ENV PRODUCTION=$PRODUCTION

# Linux dependencies
RUN apt-get update -qq && \
    apt-get install -qq -y --no-install-recommends ${APT_DEPS} && \
    apt-get -qq clean

# Nginx
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log
COPY ./config/nginx.conf /etc/nginx/nginx.conf

# Supervisor
COPY ./config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Xdebug
#COPY ./config/xdebug.ini /tmp/xdebug.ini
#RUN if [ -z "$PRODUCTION" ]; then pecl install xdebug && mv /tmp/xdebug.ini "${PHP_INI_DIR}"/conf.d/xdebug.ini; fi

# The app
WORKDIR /var/www/html/

COPY composer.json ./
#COPY composer.lock ./

RUN /usr/local/bin/composer install --no-scripts --no-autoloader $COMPOSER_ARGS

COPY . .

RUN /usr/local/bin/composer dump-autoload --optimize

# Startup
CMD ["docker/run"]