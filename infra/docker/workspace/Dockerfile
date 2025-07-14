FROM php:8.3-cli AS base

WORKDIR /workspace

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_HOME=/composer

ARG UID=1000
ARG GID=1000

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# hadolint ignore=DL3008
RUN <<EOF
  apt-get update
  apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    default-mysql-client \
    curl
  locale-gen en_US.UTF-8
  localedef -f UTF-8 -i en_US en_US.UTF-8
  docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath
  # permission denied bind mount in Linux environment
  groupadd --gid $GID phper
  useradd --uid $UID --gid $GID --create-home --shell /bin/bash phper
  mkdir /composer
  mkdir -p /home/phper/.config/psysh
  chown phper:phper /composer
  chown phper:phper /workspace
  chown phper:phper /home/phper/.config/psysh
  chown phper:phper /home/phper
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

# Install NVM and Node.js as the phper user
USER phper
ARG NODE_VERSION=22.0.0
RUN <<EOF
  export NVM_DIR="/home/phper/.nvm"
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash
  [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
  nvm install ${NODE_VERSION}
  nvm alias default ${NODE_VERSION}
  nvm use default
  # Add NVM and Node to PATH for non-interactive shells
  echo 'export NVM_DIR="/home/phper/.nvm"' >> /home/phper/.bashrc
  echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> /home/phper/.bashrc
  echo '[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"' >> /home/phper/.bashrc
EOF


FROM base AS development

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

USER phper

FROM base AS development-xdebug

RUN <<EOF
  pecl install xdebug
  docker-php-ext-enable xdebug
EOF

COPY ./infra/docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER phper

FROM base AS deploy



# Copy configuration files and application code
USER root
COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
COPY --chown=phper:phper ./src /workspace

USER phper

# Uncomment if Composer commands are needed
# RUN <<EOF
#   composer install --quiet --no-interaction --no-ansi --no-dev --no-scripts --no-progress --prefer-dist
#   composer dump-autoload --optimize
#   chmod -R 777 storage bootstrap/cache
#   php artisan optimize:clear
#   php artisan optimize
# EOF

# Set the working directory
WORKDIR /workspace

# Override the entrypoint to avoid the default php entrypoint
ENTRYPOINT []

# Default command to keep the container running
CMD ["bash"]