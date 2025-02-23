<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'shanth@hopeww.in',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
    }
}
