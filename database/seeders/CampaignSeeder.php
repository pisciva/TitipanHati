<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Category;
use Carbon\Carbon;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            [
                'organization_id' => 1,
                'title' => 'Pakaian Sekolah untuk Anak Pedalaman',
                'description' => 'Campaign untuk mengumpulkan pakaian sekolah (seragam, sepatu, tas) bagi anak-anak di daerah pedalaman Papua. Target 200 set pakaian lengkap untuk tahun ajaran baru.',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'target_quantity' => 200,
                'collected_quantity' => 145,
                'deadline' => Carbon::now()->addMonths(2),
                'status' => 'aktif',
                'view_count' => 1250,
                'categories' => [1, 2, 5, 6], // Anak Laki-laki, Anak Perempuan, Atasan, Bawahan
            ],
            [
                'organization_id' => 2,
                'title' => 'Pakaian Hangat untuk Musim Hujan',
                'description' => 'Mengumpulkan jaket, sweater, dan pakaian hangat untuk anak-anak panti asuhan menghadapi musim hujan. Kondisi pakaian harus layak pakai dan bersih.',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'target_quantity' => 150,
                'collected_quantity' => 87,
                'deadline' => Carbon::now()->addMonth(1),
                'status' => 'aktif',
                'view_count' => 890,
                'categories' => [1, 2, 5, 7], // Anak Laki-laki, Anak Perempuan, Atasan, Other
            ],
            [
                'organization_id' => 3,
                'title' => 'Baju Lebaran untuk Keluarga Prasejahtera',
                'description' => 'Program tahunan menyediakan pakaian baru dan layak pakai untuk keluarga prasejahtera menyambut hari raya. Target 300 pcs untuk 50 keluarga.',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'target_quantity' => 300,
                'collected_quantity' => 178,
                'deadline' => Carbon::now()->addMonths(3),
                'status' => 'aktif',
                'view_count' => 2100,
                'categories' => [1, 2, 3, 4, 5, 6], // Semua gender, Atasan, Bawahan
            ],
            [
                'organization_id' => 4,
                'title' => 'Pakaian Bayi dan Balita',
                'description' => 'Mengumpulkan pakaian bayi dan balita (0-5 tahun) untuk keluarga tidak mampu. Prioritas pakaian dalam kondisi baik dan bersih.',
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
                'target_quantity' => 250,
                'collected_quantity' => 230,
                'deadline' => Carbon::now()->addWeeks(3),
                'status' => 'aktif',
                'view_count' => 567,
                'categories' => [1, 2, 5, 6, 7], // Anak, semua kategori
            ],
            [
                'organization_id' => 5,
                'title' => 'Pakaian untuk Korban Bencana Alam',
                'description' => 'Campaign darurat untuk mengumpulkan pakaian bagi korban banjir di Yogyakarta. Dibutuhkan segera untuk 100 keluarga yang kehilangan tempat tinggal.',
                'province' => 'DI Yogyakarta',
                'city' => 'Yogyakarta',
                'target_quantity' => 400,
                'collected_quantity' => 356,
                'deadline' => Carbon::now()->addWeeks(2),
                'status' => 'aktif',
                'view_count' => 3400,
                'categories' => [1, 2, 3, 4, 5, 6, 7], // Semua kategori
            ],
            [
                'organization_id' => 1,
                'title' => 'Seragam Olahraga Sekolah',
                'description' => 'Mengumpulkan pakaian olahraga (kaos, celana training, sepatu) untuk siswa SD di daerah tertinggal.',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Timur',
                'target_quantity' => 180,
                'collected_quantity' => 95,
                'deadline' => Carbon::now()->addMonth(1)->addWeeks(2),
                'status' => 'aktif',
                'view_count' => 720,
                'categories' => [1, 2, 5, 6], // Anak, Atasan, Bawahan
            ],
            [
                'organization_id' => 3,
                'title' => 'Pakaian Kerja untuk Pelatihan Vokasi',
                'description' => 'Campaign untuk mendukung program pelatihan kerja dengan menyediakan pakaian kerja (kemeja, celana panjang) bagi peserta dari keluarga kurang mampu.',
                'province' => 'Jawa Barat',
                'city' => 'Bekasi',
                'target_quantity' => 120,
                'collected_quantity' => 120,
                'deadline' => Carbon::now()->subWeeks(1),
                'status' => 'selesai',
                'view_count' => 450,
                'categories' => [3, 4, 5, 6], // Dewasa, Atasan, Bawahan
            ],
            [
                'organization_id' => 2,
                'title' => 'Pakaian Muslim untuk Pondok Pesantren',
                'description' => 'Mengumpulkan pakaian muslim (sarung, peci, mukena, jilbab) untuk santri di pondok pesantren yang membutuhkan.',
                'province' => 'Jawa Timur',
                'city' => 'Malang',
                'target_quantity' => 200,
                'collected_quantity' => 200,
                'deadline' => Carbon::now()->subMonths(1),
                'status' => 'selesai',
                'view_count' => 890,
                'categories' => [1, 2, 3, 4, 7], // Semua gender, Other
            ],
        ];

        foreach ($campaigns as $campaignData) {
            $categories = $campaignData['categories'];
            unset($campaignData['categories']);
            
            $campaign = Campaign::create($campaignData);
            

            $campaign->categories()->attach($categories);
        }
        
        $this->command->info('✅ Campaigns seeded successfully!');
    }
}