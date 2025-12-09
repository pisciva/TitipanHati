<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder aplikasi
        $this->call([
            CategorySeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            OrganizationSeeder::class,
            CampaignSeeder::class,
            TestimonialSeeder::class,
            DonationSeeder::class,
        ]);

        $this->call(\Laravolt\Indonesia\Seeds\ProvincesSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\CitiesSeeder::class);
        $this->call(\Laravolt\Indonesia\Seeds\DistrictsSeeder::class);

        // Fix Indonesia names langsung di sini
        $tables = ['indonesia_provinces', 'indonesia_cities', 'indonesia_districts'];
        foreach ($tables as $table) {
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                DB::table($table)->where('id', $row->id)->update([
                    'name' => Str::title(strtolower($row->name))
                ]);
            }
        }
    }
}
