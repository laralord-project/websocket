
FROM laralordproject/server:v0.1.2-rc13 AS dev

ARG APP_VERSION
ENV APP_VERSION "${APP_VERSION}"

RUN echo Building ${APP_VERSION}

USER root
RUN install-php-extensions opcache
COPY ./deploy/php/tests.bootstrap.sh /usr/bin/test
COPY ./deploy/bootstrap.sh /bootstrap.sh
COPY ./deploy/supervisord/supervisord.ini /etc/supervisor/supervisord.conf
COPY . /var/www

RUN mkdir ./bootstrap/cache
RUN chown www:www -R /var/www && chmod +x /usr/bin/test /bootstrap.sh
RUN git config --global --add safe.directory /var/www

USER www
CMD ["/bootstrap.sh"]

# image from build
FROM dev AS build

RUN composer install --no-dev --no-progress -o
RUN npm install
RUN php artisan view:cache && php artisan route:cache
USER root
COPY ./deploy/php/php.ini /usr/local/etc/php/php.ini
RUN apt-get clean
USER www


FROM dev AS xdebug
USER root
RUN install-php-extensions xdebug
USER www
