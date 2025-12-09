<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'budi@example.com',
                'full_name' => 'Budi Santoso',
                'phone' => '081234567891',
                'address' => 'Jl. Gatot Subroto No. 123',
                'city' => 'Jakarta',
                'district' => 'Jakarta Selatan',
                'postal' => '12190',
            ],
            [
                'email' => 'siti@example.com',
                'full_name' => 'Siti Nurhaliza',
                'phone' => '081234567892',
                'address' => 'Jl. Merdeka No. 45',
                'city' => 'Bandung',
                'district' => 'Bandung Wetan',
                'postal' => '40111',
            ],
            [
                'email' => 'ahmad@example.com',
                'full_name' => 'Ahmad Dahlan',
                'phone' => '081234567893',
                'address' => 'Jl. Pemuda No. 78',
                'city' => 'Surabaya',
                'district' => 'Gubeng',
                'postal' => '60281',
            ],
            [
                'email' => 'rina@example.com',
                'full_name' => 'Rina Wijaya',
                'phone' => '081234567894',
                'address' => 'Jl. Ahmad Yani No. 90',
                'city' => 'Semarang',
                'district' => 'Semarang Tengah',
                'postal' => '50132',
            ],
            [
                'email' => 'doni@example.com',
                'full_name' => 'Doni Pratama',
                'phone' => '081234567895',
                'address' => 'Jl. Diponegoro No. 56',
                'city' => 'Yogyakarta',
                'district' => 'Gondokusuman',
                'postal' => '55223',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'email' => $userData['email'],
                'password' => Hash::make('password123'),
                'role' => 'donatur',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'full_name' => $userData['full_name'],
                'phone_number' => $userData['phone'],
                'default_address' => $userData['address'],
                'default_province' => $userData['city'],
                'default_city' => $userData['district'],
                'default_postal_code' => $userData['postal'],
            ]);
        }
        
        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('🔑 All users password: password123');
    }
}