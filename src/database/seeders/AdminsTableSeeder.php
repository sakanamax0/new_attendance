<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'master',
            'email' => 'master@yahoo.co.jp',
            'password' => Hash::make('master7'),  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
