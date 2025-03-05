<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckAdmin extends Command
{
    protected $signature = 'admin:check';
    protected $description = 'Check admin user details';

    public function handle()
    {
        $admin = User::where('email', 'shanth@hopeww.in')->first();
        if ($admin) {
            $this->info('Admin user exists:');
            $this->table(
                ['ID', 'Name', 'Email', 'Role'],
                [[$admin->id, $admin->name, $admin->email, $admin->role]]
            );
        } else {
            $this->error('Admin user not found!');
        }
    }
}
