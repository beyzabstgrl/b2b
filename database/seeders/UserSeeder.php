<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        //  1
        User::updateOrCreate(
            ['email' => 'ali@example.com'],
            [
                'name'     => 'Ali',
                'password' => Hash::make('secret123'),
                'role'     => 'customer',
            ]
        );

        //  2
        User::updateOrCreate(
            ['email' => 'zeynep@example.com'],
            [
                'name'     => 'zeynep',
                'password' => Hash::make('secret123'),
                'role'     => 'customer',
            ]
        );
    }
}
