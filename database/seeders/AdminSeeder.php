<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {

        $admin = User::create([
            'email' => 'admin@titipanhati.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);


        UserProfile::create([
            'user_id' => $admin->id,
            'full_name' => 'Admin TitipanHati',
            'phone_number' => '081234567890',
            'default_address' => 'Jl. Sudirman No. 1',
            'default_city' => 'Jakarta',
            'default_district' => 'Jakarta Pusat',
            'default_postal_code' => '10110',
            'default_notes' => 'Dekat stasiun MRT',
        ]);
        
        $this->command->info('✅ Admin seeded successfully!');
        $this->command->info('📧 Email: admin@titipanhati.com');
        $this->command->info('🔑 Password: admin123');
    }
}