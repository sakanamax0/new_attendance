<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('breaktimes', function (Blueprint $table) {
            // 不要なカラムの削除
            foreach (['some_column1', 'some_column2'] as $col) {
                if (Schema::hasColumn('breaktimes', $col)) {
                    $table->dropColumn($col);
                }
            }

            // 必要なカラムの追加（存在しない場合のみ）
            if (!Schema::hasColumn('breaktimes', 'break_start_time')) {
                $table->dateTime('break_start_time')->nullable();
            }

            if (!Schema::hasColumn('breaktimes', 'break_end_time')) {
                $table->dateTime('break_end_time')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('breaktimes', function (Blueprint $table) {
            $table->dropColumn(['break_start_time', 'break_end_time']);
        });
    }
};
