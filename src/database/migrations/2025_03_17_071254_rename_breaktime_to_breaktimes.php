<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBreaktimeToBreaktimes extends Migration
{
    public function up()
{
    Schema::rename('breaktime', 'breaktimes');
}

public function down()
{
    Schema::rename('breaktimes', 'breaktime');
}

}
