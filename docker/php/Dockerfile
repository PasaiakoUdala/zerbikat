FROM php:5.6-fpm

ARG USER_ID=${USER_ID}
ARG GROUP_ID=${GROUP_ID}
ARG WITH_XDEBUG=${WITH_XDEBUG}
ARG DOCKER_TIMEZONE=${DOCKER_TIMEZONE}

#USER ${USER_ID}:${GROUP_ID}

RUN echo "Timezone => " ${DOCKER_TIMEZONE}
RUN echo "GROUP_ID => " ${GROUP_ID}
RUN echo "USER_ID => " ${USER_ID}
RUN echo " XDEBUG  => " ${WITH_XDEBUG}

RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data


#USER www-data
RUN echo 'www-data ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list
RUN apt-get update && apt-get install -y \
    openssl \
    git \
    htop \
    iputils-ping \
    vim \
    unzip locales openssh-client \
    zlib1g-dev libonig-dev libpng-dev \
    libxml2-dev \
    grc \
    iputils-ping \
    && locale-gen es_ES.UTF-8 \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/environment \
    && echo "LANG=es_ES.UTF-8" >> /etc/environment \
    && echo "LC_ALL=es_ES.UTF-8" >> /etc/default/locale \
    && echo "LANG=es_ES.UTF-8" >> /etc/default/locale

#RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/php.ini  && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN cd /tmp && \
    git clone https://github.com/xdebug/xdebug.git && \
    cd xdebug && \
    git checkout XDEBUG_2_5_5 && \
    phpize && \
    ./configure --enable-xdebug && \
    make && \
    make install && \
    rm -rf /tmp/xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/php.ini  && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&  \
    echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&  \
    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini &&  \
    echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN docker-php-ext-install pdo pdo_mysql

RUN ln -snf /usr/share/zoneinfo/${DOCKER_TIMEZONE} /etc/localtime && echo ${DOCKER_TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${DOCKER_TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

#LDAP
RUN set -x \
    && apt-get update \
    && apt-get install -y libldap2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && apt-get purge -y --auto-remove libldap2-dev

#PHP ZIP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache

RUN echo memory_limit = 512M >> /usr/local/etc/php/conf.d/zerbikat.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

RUN apt-get install curl -y
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update && apt-get install nodejs

RUN npm install gulp bower

WORKDIR /usr/src/app

COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
