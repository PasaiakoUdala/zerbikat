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

RUN if [ "${WITH_XDEBUG}" = "true" ]; then pecl install xdebug && docker-php-ext-enable xdebug && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/php.ini  && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; fi

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

# zsh eta oh my zsh
RUN apt install -y zsh wget

USER www-data
RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true
COPY ./docker/php/conf/.zshrc /home/www-data/.zshrc



WORKDIR /usr/src/app

COPY . /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
