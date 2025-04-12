<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToAttendancesTable extends Migration
{
    public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        // すでにカラムが存在しないか確認
        if (!Schema::hasColumn('attendances', 'reason')) {
            $table->text('reason')->nullable()->after('clock_out');
        }
    });
}


    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // reasonカラムを削除
            $table->dropColumn('reason');
        });
    }
}
