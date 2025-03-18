<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksToAttendances extends Migration
{
    public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->text('remarks')->nullable()->after('clock_out');
    });
}

public function down()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->dropColumn('remarks');
    });
}

}
