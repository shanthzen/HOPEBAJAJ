<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'shanth@hopeww.in',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin'
        ]);
        $this->info('Admin created successfully!');
    }
}
