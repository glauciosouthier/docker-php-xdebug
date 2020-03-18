FROM php:5.6-fpm as phpBase

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install --no-install-recommends -y \
    git \
    unzip \
    tar \
    locales \
    vim \
    wget  \
    build-essential \
    libaio1 \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install intl mbstring zip gd \
    && apt-get clean 

FROM phpBase as phpBase2

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ] ; then \
    yes | pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug \
;fi


ARG INSTALL_POSTGRES=false
RUN if [ ${INSTALL_POSTGRES} = true ] ; then \
     docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
;fi

ARG INSTALL_MYSQL=false
RUN if [ ${INSTALL_MYSQL} = true ] ; then \
    docker-php-ext-install pdo mysql \
;fi

ARG INSTALL_ORACLE=false
COPY ./docker/oracle/ /usr/local
WORKDIR /usr/local
RUN if [ ${INSTALL_ORACLE} = true ] ; then \
     unzip -oq instantclient-basic-linux.x64-12.2.0.1.0.zip  \
    && unzip -oq instantclient-sdk-linux.x64-12.2.0.1.0.zip  \
    && ln -s /usr/local/instantclient_12_2 /usr/local/instantclient \
    && ln -s /usr/local/instantclient/libclntsh.so.* /usr/local/instantclient/libclntsh.so \
    && ln -s /usr/local/instantclient/lib* /usr/lib \
    && ln -s /usr/local/instantclient/libocci.so.* /usr/local/instantclient/libocci.so \
    && echo "/opt/oracle/instantclient_12_2" > /etc/ld.so.conf.d/oracle-instantclient \
    && docker-php-ext-configure oci8 --with-oci8=instantclient,/usr/local/instantclient \
    && docker-php-ext-install oci8 \
    #&& docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/usr/local/instantclient \
    #&& docker-php-ext-install pdo_oci \
;fi

FROM phpBase2
WORKDIR /var/www/html

ARG INSTALL_NODE=false
RUN if [ ${INSTALL_NODE} = true ] ; then \
  curl -sL https://deb.nodesource.com/setup_12.x | bash - \
  && apt-get install -y nodejs \
;fi

WORKDIR /var/www/html
COPY . /var/www/html


RUN rm -rf /var/www/html/data/cache/
#RUN mkdir -p /var/www/html/data/cache/twig

ARG INSTALL_COMPOSER=false
RUN if [ ${INSTALL_COMPOSER} = true ] ; then \
  curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer \
  && git config --global http.sslverify false \
  && composer install \
  && composer dump-autoload --optimize \
  #&& composer run-scripts post-install-cmd \
;fi

# Permissions
#RUN chown -R www-data:www-data /var/www/html
#RUN chmod -R 775 /var/www/html







