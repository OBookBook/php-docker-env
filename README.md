## 環境概要
- php:8.2-apache
- mysql:8.0
- phpmyadmin:latest
- xdebug
- Composer
- php_codesniffer

## ディレクトリ構造とファイルの役割

プロジェクトのディレクトリ構造と各ファイルの役割は以下の通りです：

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

## 使い方

### Dockerファイルがあるプロジェクトへ移動
1. Dockerを起動してコンテナを作るコマンドです。
```shell
docker-compose up -d
```

### Webサーバが正常に動いているか確認
これは私のプロジェクトのindex.phpファイルのトップページです。
![](https://storage.googleapis.com/zenn-user-upload/73bd365d50f6-20231029.png)
2. 以下のURLでアクセスできます：[http://localhost:9080/](http://localhost:9080/)

### phpMyAdminが正常に動いているか確認
![](https://storage.googleapis.com/zenn-user-upload/ab6f97676c59-20231029.png)
3. 以下のURLでアクセスできます：[http://localhost:9090/](http://localhost:9090/)

### Dockerコンテナにログイン
4. Dockerコンテナ内に入るために、次のコマンドを実行してください：
```shell
docker container exec -it php bash
```

### composerでphp_codesnifferをダウンロード
5. 必要なパッケージをインストールするために、以下のコマンドを実行してください：
```shell
composer install
```

### 静的解析ツールを使ってみよう
6. PHP_CodeSnifferを使用してPSR-12の静的解析を実行するために、以下のコマンドを実行してください：
```shell
./vendor/bin/phpcs --standard=PSR12 ./index.php
```

### xdebugを使ってみよう
7. VSCodeでデバッグ実行
![](https://storage.googleapis.com/zenn-user-upload/a4a009797151-20231029.png)
Xdebugを活用するために、以下の手順を実行してください：
1\. index.phpにブレイクポイントを貼る
2\. VSCodeでデバッグ実行を押す
3\. プラウザからindex.phpを叩く!!以下のURLでアクセスできます
以下のURLでアクセスできます：[http://localhost:9080/](http://localhost:9080/)
