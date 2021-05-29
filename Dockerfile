FROM chialab/php:8.0-fpm

ARG IS_DOCKER=
ARG PRODUCTION=
ARG COMPOSER_ARGS=

ENV DEBIAN_FRONTEND noninteractive
ENV APT_DEPS supervisor nginx-extras curl default-mysql-client gpg unzip
ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /composer/vendor/bin:$PATH
ENV IS_DOCKER=$IS_DOCKER
ENV PRODUCTION=$PRODUCTION

# Linux dependencies
RUN apt-get update -qq && \
    apt-get install -qq -y --no-install-recommends ${APT_DEPS} && \
    apt-get -qq clean

# Nginx
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log
COPY ./build/docker/nginx.conf /etc/nginx/nginx.conf
COPY ./build/docker/vhost.conf /etc/nginx/conf.d/vhost.conf

# Supervisor
COPY ./build/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Xdebug
COPY ./build/docker/xdebug.ini /tmp/xdebug.ini
RUN if [ -z $PRODUCTION ]; then pecl install xdebug && mv /tmp/xdebug.ini "${PHP_INI_DIR}"/conf.d/xdebug.ini; fi

# The app
WORKDIR /var/www/html/
COPY . .

RUN /usr/local/bin/composer install -o $COMPOSER_ARGS

# Startup
CMD ["build/docker/entrypoint"]