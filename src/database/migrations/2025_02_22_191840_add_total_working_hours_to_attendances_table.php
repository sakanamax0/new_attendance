<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('attendances', function (Blueprint $table) {
      if (!Schema::hasColumn('attendances', 'break_start_time')) {
        $table->timestamp('break_start_time')->nullable()->after('clock_out');
      }

      if (!Schema::hasColumn('attendances', 'break_end_time')) {
        $table->timestamp('break_end_time')->nullable()->after('break_start_time');
      }

      if (!Schema::hasColumn('attendances', 'total_working_hours')) {
        $table->integer('total_working_hours')->nullable()->after('break_end_time');
      }
    });
  }

  public function down()
  {
    Schema::table('attendances', function (Blueprint $table) {
      if (Schema::hasColumn('attendances', 'break_start_time')) {
        $table->dropColumn('break_start_time');
      }

      if (Schema::hasColumn('attendances', 'break_end_time')) {
        $table->dropColumn('break_end_time');
      }

      if (Schema::hasColumn('attendances', 'total_working_hours')) {
        $table->dropColumn('total_working_hours');
      }
    });
  }
};
