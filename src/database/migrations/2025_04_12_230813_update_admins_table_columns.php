<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('admins', function (Blueprint $table) {
            // 不要なカラム削除（もし存在していれば）
            foreach (['some_column1', 'some_column2'] as $col) {
                if (Schema::hasColumn('admins', $col)) {
                    $table->dropColumn($col);
                }
            }

            // 必須カラムの追加（なければ）
            if (!Schema::hasColumn('admins', 'name')) {
                $table->string('name')->nullable(false);
            }

            if (!Schema::hasColumn('admins', 'email')) {
                $table->string('email')->unique()->nullable(false);
            }

            if (!Schema::hasColumn('admins', 'password')) {
                $table->string('password')->nullable(false);
            }
        });
    }

    public function down(): void {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'password']);
        });
    }
};
