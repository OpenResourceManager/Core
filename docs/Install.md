# ORM Core Install

### Requirements:

- php >= 7.0.0
- Redis
- MariaDB/MySQL (tested on MariaDB 10.1)
- [Yarn](https://yarnpkg.com/) -- For development*
- [composer](https://getcomposer.org/)
- NGINX or Apache (tested on NGINX)

PHP Packages:

- php-pecl-redis
- php-pdo
- php-mysqlnd
- php-mcrypt
- php-mbstring
- php-gd
- php-xml
- php-fpm (NGINX only)

### Install:

* [Install NGINX](https://github.com/MelonSmasher/NginxInstaller)

* Install MariaDB

* Install Redis

* Install PHP and extensions

* Initialize the DB

```mysql
create database orm;
CREATE USER 'orm'@'localhost' IDENTIFIED BY 'SOMESTRONGPASSWORD';
GRANT ALL PRIVILEGES ON orm.* To 'orm'@'localhost';
FLUSH PRIVILEGES;
```

* Initialize ORM

```bash
# Create a vendor dir
sudo mkdir /home/nginx;

# Set the right permissions
sudo chown -R nginx:nginx /home/nginx;

# Go to the web root
cd /usr/share/nginx/html/;

# Clone Repo with composer
sudo -u nginx composer create-project open-resource-manager/core OpenResourceManager/Core dev-master --keep-vcs --no-dev; 

# Get into the project
cd OpenResourceManager/Core;
```

* Configure environment settings

```bash
sudo -u nginx vi .env;
```

* DB Migrations and Seeds

```bash
# Run DB Migrations
sudo -u nginx php artisan migrate --force;

# Seed DB With Default Assets
sudo -u nginx php artisan db:seed --force;
```
