<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedToAttendances extends Migration
{
    public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->boolean('is_locked')->default(false)->after('remarks');
    });
}

public function down()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->dropColumn('is_locked');
    });
}

}
