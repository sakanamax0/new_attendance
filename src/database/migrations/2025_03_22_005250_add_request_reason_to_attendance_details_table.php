<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestReasonToAttendanceDetailsTable extends Migration
{
    public function up()
{
    Schema::table('attendance_details', function (Blueprint $table) {
        $table->text('request_reason')->nullable()->after('remarks'); // 申請理由のカラムを追加
    });
}

public function down()
{
    Schema::table('attendance_details', function (Blueprint $table) {
        $table->dropColumn('request_reason');
    });
}
}
