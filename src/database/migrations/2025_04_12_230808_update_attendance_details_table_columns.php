<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('attendance_details', function (Blueprint $table) {
            // 必要なカラム以外は削除（今の定義：remarks, request_reason, created_at, updated_at）
            // 不要なカラムの削除（仮に存在していれば）
            foreach (['some_other_column1', 'some_other_column2'] as $col) {
                if (Schema::hasColumn('attendance_details', $col)) {
                    $table->dropColumn($col);
                }
            }

            // 必要なカラムの再定義（存在しない場合のみ）
            if (!Schema::hasColumn('attendance_details', 'remarks')) {
                $table->text('remarks')->nullable();
            }
            if (!Schema::hasColumn('attendance_details', 'request_reason')) {
                $table->text('request_reason')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('attendance_details', function (Blueprint $table) {
            // 必要なカラムを削除
            $table->dropColumn(['remarks', 'request_reason']);

            // （ダウングレード時に復元が必要な場合は、元の不要カラムの追加などもここに）
        });
    }
};
