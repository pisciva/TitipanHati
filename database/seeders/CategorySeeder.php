<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Gender categories
            ['name' => 'Anak Laki-laki', 'type' => 'gender'],
            ['name' => 'Anak Perempuan', 'type' => 'gender'],
            ['name' => 'Laki-laki', 'type' => 'gender'],
            ['name' => 'Perempuan', 'type' => 'gender'],
            
            // Item type categories
            ['name' => 'Atasan', 'type' => 'item_type'],
            ['name' => 'Bawahan', 'type' => 'item_type'],
            ['name' => 'Other', 'type' => 'item_type'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
        
        $this->command->info('✅ Categories seeded successfully!');
    }
}