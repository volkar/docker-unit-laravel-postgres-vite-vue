FROM alpine:edge

LABEL maintainer="sergey@volkar.ru"

# Args from .env file
ARG GIT_EMAIL
ARG GIT_NAME
ARG PHPVERSION

# Create /www dir for server root
RUN mkdir /www && \
    apk update && \
    apk upgrade && \
    # PHP \
    apk add --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/community php${PHPVERSION} && \
    # Common packages \
    apk add --no-cache curl git bash make && \
    # Common extensions
    apk add --no-cache php${PHPVERSION}-phar php${PHPVERSION}-mbstring php${PHPVERSION}-iconv php${PHPVERSION}-openssl && \
    # Install unit & php \
    apk add --no-cache unit unit-php81 unit-openrc && \
    # Laravel required php extensions \
    apk add --no-cache php${PHPVERSION}-bcmath php${PHPVERSION}-ctype php${PHPVERSION}-xml php${PHPVERSION}-tokenizer php${PHPVERSION}-dom php${PHPVERSION}-xmlwriter php${PHPVERSION}-curl php${PHPVERSION}-fileinfo php${PHPVERSION}-session && \
    # OPCache \
    apk add --no-cache php${PHPVERSION}-opcache && \
    # Postgres \
    apk add --no-cache php${PHPVERSION}-pdo_pgsql && \
    # GD
    # apk add --no-cache php81-gd && \
    # Imagick
    # apk add --no-cache php${PHPVERSION}-pecl-imagick php${PHPVERSION}-pecl-imagick-dev && \
    # Intl
    # apk add --no-cache php81-intl && \
    # Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Git config
    git config --global user.email "${GIT_EMAIL}" && \
    git config --global user.name "${GIT_NAME}"

# Set workdir
WORKDIR /www

# Laravel binaries
RUN composer global require laravel/installer

# Set permissions
RUN chown -R unit:unit /var/lib/unit && chown -R unit:unit /www

# Update PATH with composer binaries
ENV PATH="${PATH}:~/.composer/vendor/bin"

# XDebug
# RUN apk add --no-cache php${PHPVERSION}-pecl-xdebug
# COPY ./docker_configs/xdebug.ini /etc/php${PHPVERSION}/conf.d/50_xdebug.ini

# Copy shell script to entrypoint dir
COPY ./docker_configs/docker-entrypoint.sh /docker-entrypoint.d/docker-entrypoint.sh
# Copy unit initial config file to entrypoint dir
COPY ./docker_configs/config.json /docker-entrypoint.d/config.json
# Copy php.ini
COPY ./docker_configs/php.ini /etc/php${PHPVERSION}/php.ini

# Run unit
CMD ["unitd", "--no-daemon", "--control", "unix:/run/control.unit.sock", "--log", "/dev/stderr"]

# Entrypoint
ENTRYPOINT ["/docker-entrypoint.d/docker-entrypoint.sh"]