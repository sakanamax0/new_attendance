<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // プライマリキー
            $table->string('name'); // 管理者名
            $table->string('email')->unique(); // メールアドレス（ユニーク制約）
            $table->string('password'); // パスワード
            $table->timestamps(); // 作成日時、更新日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins'); // テーブル削除
    }
}
