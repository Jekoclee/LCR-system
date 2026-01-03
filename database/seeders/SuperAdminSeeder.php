<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin (Tine)
        User::updateOrCreate(
            ['email' => 'tine@lcr.com'],
            [
                'name' => 'Tine',
                'password' => Hash::make('12345'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // Create Admin (Mae)
        User::updateOrCreate(
            ['email' => 'mae@lcr.com'],
            [
                'name' => 'Mae',
                'password' => Hash::make('54321'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin accounts updated successfully!');
        $this->command->info('👑 Super Admin: tine@lcr.com / 12345');
        $this->command->info('🛡️ Admin: mae@lcr.com / 54321');
    }
}

