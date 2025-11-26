<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Koki Dapur',
                'email' => 'koki@gmail.com',
                'password' => Hash::make('koki123'),
                'role' => 'koki',
            ],
        ]);
    }
}
