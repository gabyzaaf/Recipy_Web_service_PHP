FROM ubuntu:latest
MAINTAINER SOLenG <sola-prog@live.fr>

RUN locale-gen en_US.UTF-8 \
	&& export LANG=en_US.UTF-8 \
	&& apt-get update \
	&& apt-get upgrade -y
	&& apt-get install -y software-properties-common \
	&& apt-get install -y language-pack-en-base \
	&& LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/php \
	&& apt-get update \
    && apt-get -y install apache2 libapache2-mod-php7.0 \
        php7.0 php7.0-cli php-xdebug php7.0-mbstring sqlite3 php7.0-mysql php-apcu php-apcu-bc php-imagick php-memcached php-pear \
        curl imagemagick php7.0-dev php7.0-phpdbg php7.0-gd php7.0-json php7.0-curl php7.0-sqlite3 php7.0-intl \
        npm nodejs-legacy \
        vim git-core wget libsasl2-dev libssl-dev libsslcommon2-dev libcurl4-openssl-dev \
	&& a2enmod headers \
	&& a2enmod rewrite \
RUN apt-get install -y php7.0-bcmath

# Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i "s/variables_order.*/variables_order = \"EGPCS\"/g" /etc/php5/apache2/php.ini && \
    sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log
RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR


VOLUME [ "/var/www/html" ]
WORKDIR /var/www/html

EXPOSE 80

ENTRYPOINT [ "/usr/sbin/apache2" ]
CMD ["-D", "FOREGROUND"]