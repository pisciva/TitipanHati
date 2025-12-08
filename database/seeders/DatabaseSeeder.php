<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            OrganizationSeeder::class,
            CampaignSeeder::class,
            TestimonialSeeder::class,
            DonationSeeder::class,
        ]);
        
        $this->command->info('');
        $this->command->info('🎉 ALL SEEDERS COMPLETED!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('📧 Admin: cs@titipanhati.com | Password: admin123');
        $this->command->info('📧 Users: budi@example.com (and others) | Password: password123');
    }
}