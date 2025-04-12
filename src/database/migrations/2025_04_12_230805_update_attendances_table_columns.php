<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('attendances', function (Blueprint $table) {
            // 不要なカラムの削除
            $table->dropColumn(['checked_out_at', 'remarks', 'is_locked', 'break_start_time', 'break_end_time', 'total_working_hours']);

            // カラムが存在しない可能性に備えてチェック
            if (!Schema::hasColumn('attendances', 'status')) {
                $table->string('status')->nullable(false);
            }
            if (!Schema::hasColumn('attendances', 'clock_in')) {
                $table->dateTime('clock_in')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'clock_out')) {
                $table->dateTime('clock_out')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'reason')) {
                $table->text('reason')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('checked_out_at')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->dateTime('break_start_time')->nullable();
            $table->dateTime('break_end_time')->nullable();
            $table->decimal('total_working_hours', 5, 2)->nullable();

            $table->dropColumn(['status', 'clock_in', 'clock_out', 'reason']);
        });
    }
};
