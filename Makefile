.PHONY: up down build init restart logs bash composer artisan

# コンテナの起動
up:
	docker-compose up -d

# コンテナの停止・削除
down:
	docker-compose down

# コンテナのビルド（初回 or Dockerfile変更時）
build:
	docker-compose build

# 初期化（初回セットアップ）
init: up composer-install migrate seed

# Laravelの依存パッケージをインストール
composer-install:
	docker-compose exec php composer install

# マイグレーション実行
migrate:
	docker-compose exec php php artisan migrate

# ダミーデータを入れる（必要なら）
seed:
	docker-compose exec php php artisan db:seed

# コンテナ再起動
restart:
	docker-compose down && docker-compose up -d

# ログ確認（リアルタイム）
logs:
	docker-compose logs -f

# PHPコンテナの中に入る
bash:
	docker-compose exec php bash

# Laravel Artisanコマンドを実行（例: makeコマンドで `make artisan cmd="route:list"`）
artisan:
	docker-compose exec php php artisan $(cmd)

# Composerコマンドを実行（例: make composer cmd="require laravel/ui"）
composer:
	docker-compose exec php composer $(cmd)
