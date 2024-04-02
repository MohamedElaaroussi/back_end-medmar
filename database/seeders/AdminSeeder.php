<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
                // Create an admin user
                DB::table('users')->insert([
                    'name' => 'Admin',
                    'email' => 'adminhanane@gmail.com',
                    'password' => Hash::make('AdmineHanane12344321'),
                ]);
    }
}
