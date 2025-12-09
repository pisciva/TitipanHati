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
                'address' => 'Jl. Gatot Subroto No. 123, RT 005/RW 008',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'district' => 'Setiabudi',
                'postal' => '12920',
            ],
            [
                'email' => 'siti@example.com',
                'full_name' => 'Siti Nurhaliza',
                'phone' => '081234567892',
                'address' => 'Jl. Merdeka No. 45, RT 003/RW 005',
                'province' => 'Jawa Barat',
                'city' => 'Kota Bandung',
                'district' => 'Bandung Wetan',
                'postal' => '40111',
            ],
            [
                'email' => 'ahmad@example.com',
                'full_name' => 'Ahmad Dahlan',
                'phone' => '081234567893',
                'address' => 'Jl. Pemuda No. 78, RT 002/RW 004',
                'province' => 'Jawa Timur',
                'city' => 'Kota Surabaya',
                'district' => 'Gubeng',
                'postal' => '60281',
            ],
            [
                'email' => 'rina@example.com',
                'full_name' => 'Rina Wijaya',
                'phone' => '081234567894',
                'address' => 'Jl. Ahmad Yani No. 90, RT 001/RW 003',
                'province' => 'Jawa Tengah',
                'city' => 'Kota Semarang',
                'district' => 'Semarang Tengah',
                'postal' => '50132',
            ],
            [
                'email' => 'doni@example.com',
                'full_name' => 'Doni Pratama',
                'phone' => '081234567895',
                'address' => 'Jl. Diponegoro No. 56, RT 004/RW 002',
                'province' => 'DI Yogyakarta',
                'city' => 'Kota Yogyakarta',
                'district' => 'Gondokusuman',
                'postal' => '55223',
            ],
            [
                'email' => 'maya@example.com',
                'full_name' => 'Maya Anggraini',
                'phone' => '081234567896',
                'address' => 'Jl. Sudirman No. 100, RT 006/RW 001',
                'province' => 'Bali',
                'city' => 'Kota Denpasar',
                'district' => 'Denpasar Selatan',
                'postal' => '80234',
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
                'default_province' => $userData['province'],
                'default_city' => $userData['city'],
                'default_district' => $userData['district'],
                'default_postal_code' => $userData['postal'],
                'default_notes' => 'Dekat dengan landmark terdekat',
            ]);

            $this->command->info("✅ Created user: {$userData['email']}");
        }
        
        $this->command->info('');
        $this->command->info('==========================================');
        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('🔑 Default password: password123');
        $this->command->info('👤 Total users: ' . count($users));
        $this->command->info('==========================================');
    }
}