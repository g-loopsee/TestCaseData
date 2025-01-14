FROM php:8.2-fpm

RUN apt-get update && apt-get install -y cron

RUN echo "* * * * * /usr/local/bin/php /var/www/laravel/artisan schedule:run >> /var/log/cronlog.txt" > /etc/cron.d/my_cron_jobs

RUN chmod 0644 /etc/cron.d/my_cron_jobs

RUN crontab /etc/cron.d/my_cron_jobs


CMD ["cron", "-f"]

WORKDIR /var/www/laravel

RUN docker-php-ext-install pdo pdo_mysql

