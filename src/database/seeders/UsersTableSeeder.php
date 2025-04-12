<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'テストユーザ',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'attendance_status' => '出勤前', // 必要に応じて初期値変更OK
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
