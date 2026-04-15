# Pigry

## 概要

体重・食事・運動を管理できる健康管理アプリです。
ユーザーは日々の体重や摂取カロリー、運動内容を記録し、目標体重に向けた管理を行うことができます。

---

## 環境構築

### Dockerビルド

1. リポジトリをクローン

```bash
git clone git@github.com:rararamonkey/Pigry.git
cd Pigry
```

2. DockerDesktopアプリを立ち上げる

3. Docker起動

```bash
docker-compose up -d --build
```

### ※ Mac（M1 / M2）の場合

以下のエラーが出ることがあります：

```bash
no matching manifest for linux/arm64/v8
```

👉 docker-compose.yml に以下を追加

```yml
mysql:
  platform: linux/x86_64
```

---

## Laravel環境構築

1. コンテナに入る

```bash
docker-compose exec php bash
```

2. 依存関係インストール

```bash
composer install
```

3. .env作成

```bash
cp .env.example .env
```

4. 環境変数設定

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. アプリケーションキー作成

```bash
php artisan key:generate
```

6. マイグレーション実行

```bash
php artisan migrate
```

7. シーディング実行

```bash
php artisan db:seed
```

## 使用技術（実行環境）

* PHP 8.3.0
* Laravel 8.83.27
* MySQL 8.0.26
* Docker / Docker Compose

---

## テーブル設計

<img width="797" height="512" alt="image" src="https://github.com/user-attachments/assets/149c0e25-11ab-4781-a128-0b2d89fc7adc" />



---

## ER図

<img width="2844" height="1044" alt="image" src="https://github.com/user-attachments/assets/3c33389b-7ead-49a6-80cb-561576d40821" />


---

## URL

- 開発環境：http://localhost:8000/
- phpMyAdmin：http://localhost:8080/
