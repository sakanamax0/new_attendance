# 🕒 coachtech 勤怠管理アプリ

企業向けの勤怠打刻・修正申請・管理を行う Web アプリケーションです。

---

## 🚀 環境構築

### 1. リポジトリをクローン

```bash
git clone git@github.com:sakanamax0/new_attendance.git
cd new_attendance
```

### 2. Makefileを使ってコンテナを起動

初回起動時は、以下のコマンドで環境をセットアップします：

```bash
make init
```

> `docker-compose` により PHP / Nginx / MySQL / phpMyAdmin コンテナが自動起動されます。

### 3. Laravel依存パッケージのインストール

```bash
make composer-install
```

### 4. マイグレーションの実行

```bash
make migrate
```

---

## 👤 ダミーデータのログイン情報

### 管理者ログイン

- メールアドレス：`master@yahoo.co.jp`  
- パスワード：`master7`

### 一般ユーザーログイン

- メールアドレス：`ika@yahoo.co.jp`  
- パスワード：`ikaikaaa`

---

## 🗂 テーブル仕様

以下はアプリケーションで使用するデータベーステーブルの構成です。

### 🔹 `users` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
name | STRING |  |  | ○ |  
email | STRING |  | ○ | ○ |  
password | STRING |  |  | ○ |  
created_at | TIMESTAMP |  |  |  |  
updated_at | TIMESTAMP |  |  |  |  
attendance_status | STRING |  |  |  |  

---

### 🔹 `admins` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
name | STRING |  |  | ○ |  
email | STRING |  | ○ | ○ |  
password | STRING |  |  | ○ |  
created_at | TIMESTAMP |  |  |  |  
updated_at | TIMESTAMP |  |  |  |  

---

### 🔹 `attendances` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
user_id | BIGINT |  |  | ○ | users(id)  
status | STRING |  |  | ○ |  
clock_in | DATETIME |  |  |  |  
clock_out | DATETIME |  |  |  |  
reason | TEXT |  |  |  |  
created_at | TIMESTAMP |  |  |  |  
updated_at | TIMESTAMP |  |  |  |  

---

### 🔹 `breaktimes` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
attendance_id | BIGINT |  |  | ○ | attendances(id)  
break_start_time | DATETIME |  |  |  |  
break_end_time | DATETIME |  |  |  |  
created_at | TIMESTAMP |  |  |  |  
updated_at | TIMESTAMP |  |  |  |  

---

### 🔹 `attendance_details` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
attendance_id | BIGINT |  |  | ○ | attendances(id)  
updated_at | TIMESTAMP |  |  |  |  
remarks | TEXT |  |  |  |  
request_reason | TEXT |  |  |  |  
created_at | TIMESTAMP |  |  |  |  

---

### 🔹 `migrations` テーブル

カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY  
-|-|-|-|-|-
id | BIGINT | ○ |  | ○ |  
migration | STRING |  |  | ○ |  
batch | INT |  |  | ○ |  

---

## 📊 ER図

`doc/ER_diagram.png` に保存されています。  
以下のリンクから確認できます：

👉 [ER図を見る](doc/ER_diagram.png)