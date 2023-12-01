FROM debian:buster-slim

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y apache2 mariadb-server php php-mysql && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY ./arch_duk3 /var/www/html
RUN rm /var/www/html/index.html

RUN service mysql start && \
    mysql -e "CREATE USER noob@localhost IDENTIFIED BY 'noob';" && \
    mysql -e "GRANT ALL PRIVILEGES ON * . * TO noob@localhost;" && \
    mysql -e "FLUSH PRIVILEGES;" && \
    mysql -e "CREATE DATABASE Login_data;" && \
    mysql -e "USE Login_data; CREATE TABLE users(id int auto_increment primary key, username varchar(50) unique not null, password varchar(50), email varchar(50) unique not null);" && \
    mysql -e "USE Login_data; INSERT INTO users VALUES(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com');"

EXPOSE 80 3306

CMD service mysql start && \
    service apache2 start && \
    tail -f /dev/null