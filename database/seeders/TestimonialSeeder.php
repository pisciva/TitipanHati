<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

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
            ],
            [
                'name' => 'Siti Nurhaliza',
                'type' => 'donatur',
                'content' => 'Senang bisa membantu sesama melalui platform ini. Sistem penjemputan sangat membantu. Semoga semakin banyak yang terbantu.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Dahlan',
                'type' => 'donatur',
                'content' => 'Platform yang luar biasa! Saya bisa pantau langsung kemana donasi saya disalurkan. Transparansi yang sangat baik.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Yayasan Peduli Anak Indonesia',
                'type' => 'yayasan',
                'content' => 'Bantuan pakaian dari TitipanHati sangat bermanfaat bagi anak-anak asuh kami. Terima kasih para donatur yang peduli!',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Panti Asuhan Harapan Bangsa',
                'type' => 'yayasan',
                'content' => 'Kerja sama yang sangat baik. Proses penyaluran donasi cepat dan terorganisir dengan rapi. Anak-anak sangat senang.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Rina Wijaya',
                'type' => 'donatur',
                'content' => 'Aplikasi yang user-friendly dan memudahkan untuk berbagi. Sistem tracking donasi juga sangat membantu.',
                'rating' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
        
        $this->command->info('✅ Testimonials seeded successfully!');
    }
}