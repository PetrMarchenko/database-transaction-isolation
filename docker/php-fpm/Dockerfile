FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www

# Create a user with a specified username and UID
ARG USER_NAME=www-data
ARG USER_UID=1000

RUN id -u ${USER_NAME} &>/dev/null || \
    (groupadd -g ${USER_UID} ${USER_NAME} && useradd -m -u ${USER_UID} -g ${USER_NAME} ${USER_NAME}) \
    && chown -R ${USER_NAME}:${USER_NAME} /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    vim \
    libmariadb-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pgsql pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*



# Copy Composer from its official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Expose the necessary port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
