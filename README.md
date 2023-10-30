## 環境概要

- Docker
- PHP:8.2-apache
- MySQL:8.0
- phpMyAdmin:latest
- VSCode
- Xdebug
- Composer
- PHP_CodeSniffer

## ディレクトリ構造とファイルの役割

プロジェクトのディレクトリ構造と各ファイルの役割は以下の通りです。

```
├── .vscode
│   └── launch.json # VSCodeデバッグ構成を定義するファイル（xdebug設定）
├── Dockerfile
├── README.md
├── composer.json # PHP_CodeSnifferの設定
├── docker-compose.yml # Dockerコンテナの設定とphp.iniのマウント
├── index.php
└── php.ini # Xdebugの設定
```

## Dockerの設定
### docker-compose.ymlを作成
docker-compose.ymlファイルを編集し、以下の項目を各自の環境に合わせて設定してください。セキュリティ上の注意を怠らないようにしてください。
```yaml
version: "3.7"
services:
  db:
    image: mysql:8.0
    container_name: mysql
    restart: always
    environment:
      # ルートユーザのパスワードを各自で設定してください
      MYSQL_ROOT_PASSWORD: root_password_kimetene
      # データベース名を各自で設定してください
      MYSQL_DATABASE: db_local
      # データベース接続ユーザ名を各自で設定してください
      MYSQL_USER: db_user
      # データベース接続パスワードを各自で設定してください
      MYSQL_PASSWORD: db_password_kimetene
  php:
    build: ./
    container_name: php
    volumes:
      - ./php.ini:/usr/local/etc/php/php.ini
      - ./:/var/www/html
    ports:
      - 9080:80
    depends_on:
      - db
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: phpmyadmin
    restart: always
    depends_on:
      - db
    ports:
      - 9090:80
```

### Dockerfileを作成
Dockerfileを編集し、以下の内容に従って設定してください。
```Dockerfile
FROM php:8.2-apache

# xdebug 環境構築
RUN pecl install xdebug && \
  docker-php-ext-enable xdebug

# Docker 公式の Composer イメージ を使用
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Composer パッケージ管理する為の環境構築
RUN apt-get update && \
  apt-get install -y sudo git
# Composerの設定
RUN echo 'export PATH="$PATH:/root/.composer/vendor/bin"' >> /root/.bashrc
# Composerキャッシュのクリア
RUN composer global clear-cache

# php_codesniffer を使うための環境構築
RUN composer global require --no-interaction "squizlabs/php_codesniffer=*" && \
  composer require --dev --no-interaction squizlabs/php_codesniffer
```

## Compoerの設定
### composer.jsonを作成 (php_codesniffer)
composer.jsonファイルを編集して、必要なパッケージを追加してください。
PHP_CodeSnifferを使用します。
```json
{
    "require-dev": {
        "squizlabs/php_codesniffer": "^3.7"
    }
}
```

## xdebugの設定
### php.iniを作成
php.iniファイルを作成してXdebugの設定を追加してください。
```ini
[xdebug]
xdebug.client_host = host.docker.internal
xdebug.mode = debug
xdebug.start_with_request = yes
xdebug.discover_client_host = 0
xdebug.remote_handler = "dbgp"
xdebug.client_port = 9003
```

### VSCodeで拡張機能「PHP Debug」をインストール
PHP Debugで検索して、ダウンロードして下さい。
![](https://storage.googleapis.com/zenn-user-upload/bb693b4ca30d-20231029.png)

### VSCodeで「launch.json」を作成
PHP DebugをインストールしたらVSCodeの左側にデバッグボタンが出現します。
ボタンを押下して、launch.jsonを作成して下さい。
![](https://storage.googleapis.com/zenn-user-upload/bc3dfb224540-20231029.png)

### launch.jsonでxdebugの設定
Dockerで作成する開発コンテナとxdebugを繋げてます。詳しい事はコメントの通りです。
```json
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      // php.iniファイルのxdebug.client_port = 9003 と同じPORTを指定して下さい!
      "port": 9003,
      // Xdebugが動かなかったら、PATHの設定を見直してみて下さい！
      "pathMappings": {
        "/var/www/html": "${workspaceRoot}"
        // "/var/www/html": "c:/Users/***/***/***/***/***/" 絶対バスで指定したら確実に動きます。
      }
    }
```

## 使い方

### Dockerファイルがあるプロジェクトへ移動
1. Dockerを起動し、コンテナを作成するコマンドです。
```shell
docker-compose up -d
```

### Webサーバが正常に動いているか確認
本プロジェクトのトップページ(index.php)です。
![](https://storage.googleapis.com/zenn-user-upload/73bd365d50f6-20231029.png)
2. 以下のURLでアクセスできます：[http://localhost:9080/](http://localhost:9080/)

### phpMyAdminが正常に動いているか確認
![](https://storage.googleapis.com/zenn-user-upload/ab6f97676c59-20231029.png)
3. 以下のURLでアクセスできます：[http://localhost:9090/](http://localhost:9090/)

### Dockerコンテナにログイン
4. Dockerコンテナに入るコマンドです。
```shell
docker container exec -it php bash
```

### Composerでphp_codesnifferをダウンロード
5. Composerを使用してパッケージをインストールするコマンドです。
```shell
composer install
```

### 静的解析(PHP_CodeSniffer)ツールの使用方法
6. index.phpをPSR-12に従って静的解析するコマンドです。
```shell
./vendor/bin/phpcs --standard=PSR12 ./index.php
```

### xdebugの使用方法
7. VSCodeでデバッグ実行をする手順は以下の通りです。
![](https://storage.googleapis.com/zenn-user-upload/a4a009797151-20231029.png)
  * index.php ファイルにブレークポイントを設定します。
  * VSCodeでデバッグ実行を開始します。
  * プラウザからindex.phpにアクセスします。：[http://localhost:9080/](http://localhost:9080/)
