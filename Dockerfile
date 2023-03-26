FROM php:7.4-apache

# Install MySQLi extension for PHP
RUN docker-php-ext-install mysqli

# Copy the project files to the container
COPY . /var/www/html/

# Expose the web server port
EXPOSE 80

# Add the network to the container
# Replace `network_name` with the actual network name from your docker-compose.yml file
# The container needs to be on the same network as the database container
# for name resolution to work
RUN echo "networks:\n  default:\n    external:\n      name: network_name" >> /usr/local/etc/php/conf.d/docker-php-ext-networks.ini
