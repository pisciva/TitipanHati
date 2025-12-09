<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'type' => 'donatur',
                'content' => 'TitipanHati memudahkan saya untuk berbagi pakaian layak pakai. Prosesnya cepat, transparan, dan terpercaya. Sangat recommend!',
                'rating' => 5,
                'is_active' => true,
                'profile_picture' => 'testimonials/budi.jpg'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'type' => 'donatur',
                'content' => 'Senang bisa membantu melalui platform ini. Sistem penjemputan sangat membantu. Semoga semakin banyak yang terbantu.',
                'rating' => 5,
                'is_active' => true,
                'profile_picture' => 'testimonials/Siti.jpg'
            ],
            [
                'name' => 'Ahmad Dahlan',
                'type' => 'donatur',
                'content' => 'Platform yang luar biasa! Saya bisa pantau langsung kemana donasi saya disalurkan. Transparansi yang sangat baik.',
                'rating' => 5,
                'is_active' => true,
                'profile_picture' => 'testimonials/Ahmad.jpg'
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
        
        $this->command->info('✅ Testimonials seeded successfully!');
    }
}