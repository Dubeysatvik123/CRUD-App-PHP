#Base image
FROM php:8.1-apache
#Installing dependencies
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
#copying the assets
COPY . /var/www/html
#ownership to default apache user
RUN chown -R www-data:www-data /var/www/html
#Exposing the application to the default port
EXPOSE 80
#passing the default command
CMD ["apache2-foreground"]
