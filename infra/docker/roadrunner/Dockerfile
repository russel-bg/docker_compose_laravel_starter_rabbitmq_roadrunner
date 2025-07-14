FROM ghcr.io/roadrunner-server/roadrunner:2025.1.2 AS roadrunner
FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y unzip git libpq-dev libzip-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip sockets

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /workspace

# Копируем конфиг RoadRunner
# COPY . /workspace
# COPY ./infra/docker/roadrunner/.rr.yaml /workspace/.rr.yaml
# COPY .rr.yaml /workspace/.rr.yaml
COPY psr-worker.php /workspace/psr-worker.php

RUN composer require spiral/roadrunner nyholm/psr7 nyholm/psr7-server spiral/roadrunner-http --no-scripts --no-interaction

CMD ["rr", "serve", "-c", "/workspace/.rr.yaml"]
# CMD ["/bin/bash"]