FROM ubuntu:22.04
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && apt-get install -yq \
    php \
    git

WORKDIR /app
COPY . /app
RUN composer update && \
    composer install && \
    composer dump
RUN chmod +x /app/run.sh

CMD ["/bin/bash","-c", "/app/run.sh"]