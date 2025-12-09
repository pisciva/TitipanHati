<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laki-laki (Anak)', 'type' => 'gender'],
            ['name' => 'Perempuan (Anak)', 'type' => 'gender'],
            ['name' => 'Laki-laki (Dewasa)', 'type' => 'gender'],
            ['name' => 'Perempuan (Dewasa)', 'type' => 'gender'],
            

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