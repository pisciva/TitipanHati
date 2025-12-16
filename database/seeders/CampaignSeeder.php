<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use Carbon\Carbon;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            [
                'organization_id' => 1,
                'title' => 'Seragam Sekolah untuk Anak Papua',
                'description' => 'Penggalangan pakaian seragam sekolah, sepatu, dan tas bagi anak-anak di wilayah Papua Pegunungan yang mengalami keterbatasan akses pendidikan. Bantuan difokuskan untuk siswa SD–SMP menjelang tahun ajaran baru.',
                'banner_url' => 'campaigns/image1.jpg',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'target_quantity' => 200,
                'collected_quantity' => 50,
                'deadline' => Carbon::now()->addMonths(2),
                'status' => 'aktif',
                'view_count' => 1250,
                'categories' => [1, 2, 5, 6],
            ],
            [
                'organization_id' => 2,
                'title' => 'Pakaian Hangat untuk Pengungsi Semeru',
                'description' => 'Mengumpulkan jaket, sweater, dan selimut layak pakai untuk pengungsi erupsi Gunung Semeru di Jawa Timur. Bantuan ditujukan bagi anak-anak dan lansia yang tinggal di posko pengungsian.',
                'banner_url' => 'campaigns/image2.jpg',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'target_quantity' => 150,
                'collected_quantity' => 87,
                'deadline' => Carbon::now()->addMonth(1),
                'status' => 'aktif',
                'view_count' => 890,
                'categories' => [1, 2, 5, 7],
            ],
            [
                'organization_id' => 3,
                'title' => 'Baju Lebaran untuk Warga Pedalaman',
                'description' => 'Program berbagi pakaian layak pakai untuk keluarga prasejahtera di kawasan padat penduduk Kota Bandung menjelang Hari Raya Idulfitri. Bantuan diprioritaskan untuk anak-anak dan ibu rumah tangga.',
                'banner_url' => 'campaigns/image3.jpg',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'target_quantity' => 300,
                'collected_quantity' => 110,
                'deadline' => Carbon::now()->addMonths(3),
                'status' => 'aktif',
                'view_count' => 2100,
                'categories' => [1, 2, 3, 4, 5, 6],
            ],
            [
                'organization_id' => 4,
                'title' => 'Pakaian Bayi untuk Korban Banjir',
                'description' => 'Penggalangan pakaian bayi dan balita (usia 0–5 tahun) bagi keluarga yang terdampak banjir musiman di wilayah Semarang. Pakaian diharapkan dalam kondisi bersih dan layak pakai.',
                'banner_url' => 'campaigns/image4.jpg',
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
                'target_quantity' => 250,
                'collected_quantity' => 15,
                'deadline' => Carbon::now()->addWeeks(3),
                'status' => 'aktif',
                'view_count' => 567,
                'categories' => [1, 2, 5, 6, 7],
            ],
            [
                'organization_id' => 1,
                'title' => 'Seragam Olahraga Sekolah 3T',
                'description' => 'Mengumpulkan pakaian olahraga dan sepatu untuk siswa sekolah dasar di wilayah tertinggal, terdepan, dan terluar (3T) guna mendukung kegiatan belajar dan kesehatan anak.',
                'banner_url' => 'campaigns/image5.jpg',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Timur',
                'target_quantity' => 180,
                'collected_quantity' => 95,
                'deadline' => Carbon::now()->addMonth(1)->addWeeks(2),
                'status' => 'aktif',
                'view_count' => 720,
                'categories' => [1, 2, 5, 6],
            ],
            [
                'organization_id' => 2,
                'title' => 'Pakaian Muslim untuk Santri',
                'description' => 'Mengumpulkan sarung, mukena, peci, dan jilbab untuk santri pondok pesantren di Malang yang berasal dari keluarga kurang mampu.',
                'banner_url' => 'campaigns/image6.jpg',
                'province' => 'Jawa Timur',
                'city' => 'Malang',
                'target_quantity' => 200,
                'collected_quantity' => 200,
                'deadline' => Carbon::now()->subMonths(1),
                'status' => 'selesai',
                'view_count' => 890,
                'categories' => [1, 2, 3, 4, 7],
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
