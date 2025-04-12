環境構築

1.リポジトリをクローン

git clone git@github.com:sakanamax0/new_attendance.git

2.Makefileを使ってコンテナを起動
・初回起動時、以下のコマンドを実行して環境をセットアップします。

make init

※これで、docker-compose を使用して必要なコンテナ（PHP, Nginx, MySQL, phpMyAdmin）が起動します。

3.依存パッケージのインストール
・コンテナ内でLaravelの依存パッケージをインストールするため、次のコマンドを実行します。

make composer-install

4.マイグレーション実行
・データベースの初期マイグレーションを行います。

make migrate


ダミーデータのログイン情報
・管理者

メールアドレス: master@yahoo.co.jp

パスワード: master7

・一般ユーザー

メールアドレス: ika@yahoo.co.jp

パスワード: ikaikaaa

テーブル仕様
以下はアプリケーションで使用するデータベーステーブルの構成です。

🔹 users テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
name	STRING			○	
email	STRING		○	○	
password	STRING			○	
created_at	TIMESTAMP				
updated_at	TIMESTAMP				
attendance_status	STRING				

🔹 admins テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
name	STRING			○	
email	STRING		○	○	
password	STRING			○	
created_at	TIMESTAMP				
updated_at	TIMESTAMP				

🔹 attendances テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
user_id	BIGINT			○	users(id)
status	STRING			○	
clock_in	DATETIME				
clock_out	DATETIME				
reason	TEXT				
created_at	TIMESTAMP				
updated_at	TIMESTAMP				

🔹 breaktimes テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
attendance_id	BIGINT			○	attendances(id)
break_start_time	DATETIME				
break_end_time	DATETIME				
created_at	TIMESTAMP				
updated_at	TIMESTAMP				

🔹 attendance_details テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
attendance_id	BIGINT			○	attendances(id)
updated_at	TIMESTAMP				
remarks	TEXT				
request_reason	TEXT				
created_at	TIMESTAMP				

🔹 migrations テーブル
カラム名	型	PRIMARY KEY	UNIQUE KEY	NOT NULL	FOREIGN KEY
id	BIGINT	○		○	
migration	STRING			○	
batch	INT			○	

ER図
ER図は doc/ER_diagram.png に保存されています。下記リンクから確認できます。

[ER図](doc/ER_diagram.png)

PHPUnitテスト