FROM php:apache

LABEL maintainer="Vinícius Ceratti <v.ceratti@gmail.com>"

RUN apt-get update && \
    apt-get install --no-install-recommends -y \
        git libpq-dev libmcrypt-dev zlib1g-dev libxslt-dev libicu-dev graphviz libxslt-dev && \
    apt-get install -y ant ant-contrib && rm -rf /var/lib/apt/lists/*

# COMPOSER
RUN curl -Lo /usr/local/bin/composer https://getcomposer.org/composer.phar && \
    chmod +x /usr/local/bin/composer
ENV PATH=$PATH:/usr/local/bin/composer


RUN mkdir /var/www/html/.profiler/ && chmod 777 /var/www/html/.profiler

# XDEBUG
RUN yes | pecl install xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
        > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.default_enable = 1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_autostart = 0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_connect_back = 1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_host = 172.17.42.1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.profiler_enable=0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.profiler_output_dir=\"/var/www/html/.profiler\"" >> /usr/local/etc/php/conf.d/xdebug.ini

# PHPDOC
RUN cd /root && curl -L \
    https://github.com/phpDocumentor/phpDocumentor2/releases/download/v2.9.0/phpDocumentor-2.9.0.tgz | tar -xz && \
    rm -f
ENV PATH=$PATH:/root/phpDocumentor-2.9.0/bin

# PHP Unit
RUN curl -Lo /usr/local/bin/phpunit https://phar.phpunit.de/phpunit-6.3.phar && \
    chmod +x /usr/local/bin/phpunit
ENV PATH=$PATH:/usr/local/bin/phpunit

# PHPCS
RUN curl -Lo /usr/local/bin/phpcs https://github.com/squizlabs/PHP_CodeSniffer/releases/download/3.0.2/phpcs.phar && \
    chmod +x /usr/local/bin/phpcs
ENV PATH=$PATH:/usr/local/bin/phpcs

# PHPMD
RUN curl -Lo /usr/local/bin/phpmd \
        https://github.com/mi-schi/phpmd-extension/releases/download/stable/phpmd-extension.phar  && \
    chmod +x /usr/local/bin/phpmd
ENV PATH=$PATH:/usr/local/bin/phpmd

# PHPCPD
RUN curl -Lo /usr/local/bin/phpcpd https://phar.phpunit.de/phpcpd.phar && \
    chmod +x /usr/local/bin/phpcpd
ENV PATH=$PATH:/usr/local/bin/phpcpd

# PHPLOC
RUN curl -Lo /usr/local/bin/phploc https://phar.phpunit.de/phploc.phar && \
    chmod +x /usr/local/bin/phploc
ENV PATH=$PATH:/usr/local/bin/phploc

# PDEPEND
RUN curl -Lo /usr/local/bin/pdepend https://static.pdepend.org/php/2.5.0/pdepend.phar && \
    chmod +x /usr/local/bin/pdepend
ENV PATH=$PATH:/usr/local/bin/pdepend

# PHPMETRICS
RUN curl -Lo /usr/local/bin/phpmetrics \
        https://github.com/phpmetrics/PhpMetrics/releases/download/v2.2.0/phpmetrics.phar && \
    chmod +x /usr/local/bin/phpmetrics
ENV PATH=$PATH:/usr/local/bin/phpmetrics

# PHPSTAN
RUN curl -Lo /usr/local/bin/phpstan https://github.com/phpstan/phpstan/releases/download/0.8.3/phpstan.phar && \
    chmod +x /usr/local/bin/phpstan
ENV PATH=$PATH:/usr/local/bin/phpstan

# script to disable / enable xdebug for cli commands
RUN echo "mv /usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini.disabled" \
        > /usr/local/bin/disable-xdebug && \
    chmod +x /usr/local/bin/disable-xdebug && chmod 777 /usr/local/bin/disable-xdebug
ENV PATH=$PATH:/usr/local/bin/disable-xdebug

RUN echo "mv /usr/local/etc/php/conf.d/xdebug.ini.disabled /usr/local/etc/php/conf.d/xdebug.ini" \
        > /usr/local/bin/enable-xdebug && \
    chmod +x /usr/local/bin/enable-xdebug && chmod 777 /usr/local/bin/enable-xdebug
ENV PATH=$PATH:/usr/local/bin/enable-xdebug


# CHANGE THIS LINE AND RECOMPILE FOR COMPOSER SELF UPDATE
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN disable-xdebug && composer self-update  && \
    composer global require hirak/prestissimo && enable-xdebug

#RUN docker-php-ext-install mbstring mcrypt zip sockets intl bcmath xsl soap
RUN docker-php-ext-install xsl zip

#RUN docker-php-ext-install mbstring mcrypt zip sockets intl bcmath xsl soap
# configs
RUN echo "date.timezone = \"America/Sao_Paulo\"" >> /usr/local/etc/php/conf.d/timezone.ini && \
    echo "memory_limit = 1024M" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "max_execution_time = 600" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "short_open_tag = Off" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "cgi.fix_pathinfo=0" >> /usr/local/etc/php/conf.d/custom.ini

RUN a2enmod rewrite

RUN service apache2 restart

EXPOSE 80
