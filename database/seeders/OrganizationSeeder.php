<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'Yayasan Peduli Anak Indonesia',
                'description' => 'Yayasan yang fokus membantu pendidikan dan kesejahteraan anak-anak kurang mampu di seluruh Indonesia. Telah berdiri sejak 2010 dan telah membantu lebih dari 5000 anak.',
                'contact_email' => 'info@pedulianak.org',
                'contact_phone' => '08123456789',
                'address' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan',
                'logo_url' => 'organization/logo_organisasi1.png',
                'is_verified' => true,
            ],
            [
                'name' => 'Panti Asuhan Harapan Bangsa',
                'description' => 'Panti asuhan yang menampung anak yatim piatu dan memberikan pendidikan layak. Saat ini menampung 150 anak asuh.',
                'contact_email' => 'contact@harapanbangsa.org',
                'contact_phone' => '08123456789',
                'address' => 'Jl. Ahmad Yani No. 234, Surabaya',
                'logo_url' => 'organization/logo_organisasi2.png',
                'is_verified' => true,
            ],
            [
                'name' => 'Komunitas Berbagi Bandung',
                'description' => 'Komunitas sosial yang aktif mengadakan kegiatan berbagi untuk masyarakat kurang mampu di Bandung dan sekitarnya.',
                'contact_email' => 'berbagi@bandung.com',
                'contact_phone' => '08123456789',
                'address' => 'Jl. Dago No. 45, Bandung',
                'logo_url' => 'organization/logo_organisasi3.png',
                'is_verified' => true,
            ],
            [
                'name' => 'Yayasan Cahaya Harapan',
                'description' => 'Yayasan yang berfokus pada pemberdayaan masyarakat miskin kota melalui berbagai program sosial.',
                'contact_email' => 'info@cahayaharapan.org',
                'contact_phone' => '08123456789',
                'address' => 'Jl. Pemuda No. 67, Semarang',
                'logo_url' => 'organization/logo_organisasi4.png',
                'is_verified' => true,
            ],
            [
                'name' => 'Rumah Yatim Yogyakarta',
                'description' => 'Lembaga sosial yang menampung dan mendidik anak yatim serta dhuafa. Memiliki program pendidikan dan ketrampilan.',
                'contact_email' => 'contact@rumahyatim-jogja.org',
                'contact_phone' => '08123456789',
                'address' => 'Jl. Kaliurang KM 5, Yogyakarta',
                'logo_url' => 'organization/logo_organisasi5.png',
                'is_verified' => true,
            ],
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }
        
        $this->command->info('✅ Organizations seeded successfully!');
    }
}