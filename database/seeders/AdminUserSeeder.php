<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'shanth@hopeww.in'],
            [
                'name' => 'Admin',
                'email' => 'shanth@hopeww.in',
                'password' => Hash::make('Hope@123'),
                'role' => 'admin'
            ]
        );
    }
}
