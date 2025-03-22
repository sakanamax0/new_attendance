<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIsLockedFromAttendanceDetails extends Migration
{
    public function up()
{
    Schema::table('attendance_details', function (Blueprint $table) {
        $table->dropColumn('is_locked');
    });
}

public function down()
{
    Schema::table('attendance_details', function (Blueprint $table) {
        $table->boolean('is_locked')->default(0);
    });
}

}
