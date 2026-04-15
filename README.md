# Pigry（ピグリー）

## 📌 概要

体重・食事・運動を管理できる健康管理アプリです。
ユーザーは日々の体重や摂取カロリー、運動内容を記録し、目標体重に向けた管理を行うことができます。

---

## 🛠 環境構築（Docker）

### ① リポジトリをクローン

```bash
git clone git@github.com:YOUR_ACCOUNT/pigry.git
cd pigry
```

### ② Docker起動

```bash
docker-compose up -d --build
```

### ⚠️ M1 / M2 Mac の場合

以下のエラーが出ることがあります：

```bash
no matching manifest for linux/arm64/v8
```

👉 `docker-compose.yml` に以下を追加

```yml
mysql:
  platform: linux/x86_64
```

---

## ⚙️ Laravel環境構築

### ① コンテナに入る

```bash
docker-compose exec php bash
```

### ② 依存関係インストール

```bash
composer install
```

### ③ .env作成

```bash
cp .env.example .env
```

### ④ 環境変数設定

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

### ⑤ アプリキー生成

```bash
php artisan key:generate
```

### ⑥ マイグレーション

```bash
php artisan migrate
```

### ⑦ シーディング

```bash
php artisan db:seed
```

### ⑧ ストレージリンク

```bash
php artisan storage:link
```

---

## 💻 使用技術

* PHP 8.3.0
* Laravel 8.83.27
* MySQL 8.0.26
* Docker / Docker Compose

---

## 🗄 テーブル設計

* usersテーブル
* weight_logsテーブル
* weight_targetテーブル

<img width="798" height="506" alt="image" src="https://github.com/user-attachments/assets/cfb5f096-c25c-498c-b6e8-9e1f92ebdcb2" />

---

## 🔗 ER図

<img width="2844" height="1044" alt="image" src="https://github.com/user-attachments/assets/a75a6d7f-362f-43ba-9c6a-a40e27dec854" />

---

## 🌐 URL

* 開発環境: http://localhost/
* phpMyAdmin: http://localhost:8080/

---

## 📌 主な機能

* ユーザー登録 / ログイン
* 体重登録
* 食事・運動記録
* 目標体重設定
* データ編集 / 削除

---

## 📝 補足

* Docker Desktopを起動してから実行してください
* 初回は migrate・seed を必ず実行してください
