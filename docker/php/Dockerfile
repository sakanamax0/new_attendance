# PHP 7.4.9からPHP 8.1に変更
FROM php:8.1-fpm

# php.iniのコピー
COPY php.ini /usr/local/etc/php/

# 必要なパッケージをインストール
RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

# Composerのインストールとアップデート
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# 作業ディレクトリの設定
WORKDIR /var/www
