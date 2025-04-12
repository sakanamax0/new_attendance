<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // 不要なカラム削除（存在チェック付き）
            foreach (['some_column1', 'some_column2'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }

            // 必須カラムの追加
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable(false);
            }

            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->nullable(false);
            }

            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable(false);
            }

            if (!Schema::hasColumn('users', 'attendance_status')) {
                $table->string('attendance_status')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'password', 'attendance_status']);
        });
    }
};
