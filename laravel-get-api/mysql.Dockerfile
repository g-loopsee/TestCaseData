FROM mysql:8.0
ENV MYSQL_ROOT_PASSWORD=root

COPY my.cnf /etc/mysql/conf.d/
EXPOSE 5891
