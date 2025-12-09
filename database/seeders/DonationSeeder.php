<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\DonationTracking;
use App\Models\User;
use App\Models\Campaign;
use Carbon\Carbon;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'donatur')->get();
        $campaigns = Campaign::where('status', 'aktif')->get();

        // Helper district
        $getDistrict = fn($u) => $u->profile->default_district ?? 'Tidak diketahui';

        /*
        |--------------------------------------------------------------------------
        | DONATION 1
        |--------------------------------------------------------------------------
        */
        $donation1 = Donation::create([
            'user_id'           => $users[0]->id,
            'campaign_id'       => $campaigns[0]->id,
            'donor_name'        => $users[0]->profile->full_name,
            'donor_phone'       => $users[0]->profile->phone_number,
            'donor_email'       => $users[0]->email,
            'pickup_address'    => $users[0]->profile->default_address,
            'pickup_province'   => $users[0]->profile->default_province,
            'pickup_city'       => $users[0]->profile->default_city,
            'pickup_district'   => $getDistrict($users[0]),
            'pickup_postal_code'=> $users[0]->profile->default_postal_code,
            'pickup_notes'      => 'Mohon hubungi 30 menit sebelum datang',
            'pickup_date'       => Carbon::now()->subDays(5),
            'pickup_time_slot'  => '09:00-13:00',
            'status'            => 'selesai',
            'created_at'        => Carbon::now()->subDays(10),
        ]);

        DonationItem::create([
            'donation_id'    => $donation1->id,
            'gender'         => 'Laki-laki (Anak)',
            'item_category'  => 'Atasan',
            'quantity'       => 5,
            'condition'      => 'Layak pakai',
        ]);

        DonationItem::create([
            'donation_id'    => $donation1->id,
            'gender'         => 'Laki-laki (Anak)',
            'item_category'  => 'Bawahan',
            'quantity'       => 5,
            'condition'      => 'Layak pakai',
        ]);

        DonationTracking::create([
            'donation_id'        => $donation1->id,
            'status'             => 'menunggu_penjemputan',
            'notes'              => 'Donasi berhasil dibuat',
            'status_changed_at'  => Carbon::now()->subDays(10),
        ]);

        DonationTracking::create([
            'donation_id'        => $donation1->id,
            'status'             => 'dalam_perjalanan',
            'notes'              => 'Barang telah dijemput kurir',
            'status_changed_at'  => Carbon::now()->subDays(5),
        ]);

        DonationTracking::create([
            'donation_id'        => $donation1->id,
            'status'             => 'selesai',
            'notes'              => 'Barang telah sampai dan disalurkan kepada penerima',
            'status_changed_at'  => Carbon::now()->subDays(3),
        ]);


        /*
        |--------------------------------------------------------------------------
        | DONATION 2
        |--------------------------------------------------------------------------
        */
        $donation2 = Donation::create([
            'user_id'           => $users[1]->id,
            'campaign_id'       => $campaigns[1]->id,
            'donor_name'        => $users[1]->profile->full_name,
            'donor_phone'       => $users[1]->profile->phone_number,
            'donor_email'       => $users[1]->email,
            'pickup_address'    => $users[1]->profile->default_address,
            'pickup_province'   => $users[1]->profile->default_province,
            'pickup_city'       => $users[1]->profile->default_city,
            'pickup_district'   => $getDistrict($users[1]),
            'pickup_postal_code'=> $users[1]->profile->default_postal_code,
            'pickup_date'       => Carbon::now()->subDays(1),
            'pickup_time_slot'  => '13:00-17:00',
            'status'            => 'dalam_perjalanan',
            'created_at'        => Carbon::now()->subDays(5),
        ]);

        DonationItem::create([
            'donation_id'    => $donation2->id,
            'gender'         => 'Perempuan (Anak)',
            'item_category'  => 'Atasan',
            'quantity'       => 8,
            'condition'      => 'Baru',
        ]);

        DonationTracking::create([
            'donation_id'        => $donation2->id,
            'status'             => 'menunggu_penjemputan',
            'notes'              => 'Donasi berhasil dibuat',
            'status_changed_at'  => Carbon::now()->subDays(5),
        ]);

        DonationTracking::create([
            'donation_id'        => $donation2->id,
            'status'             => 'dalam_perjalanan',
            'notes'              => 'Barang sedang dalam perjalanan ke yayasan',
            'status_changed_at'  => Carbon::now()->subDays(1),
        ]);


        /*
        |--------------------------------------------------------------------------
        | DONATION 3
        |--------------------------------------------------------------------------
        */
        $donation3 = Donation::create([
            'user_id'           => $users[2]->id,
            'campaign_id'       => $campaigns[2]->id,
            'donor_name'        => $users[2]->profile->full_name,
            'donor_phone'       => $users[2]->profile->phone_number,
            'donor_email'       => $users[2]->email,
            'pickup_address'    => $users[2]->profile->default_address,
            'pickup_province'   => $users[2]->profile->default_province,
            'pickup_city'       => $users[2]->profile->default_city,
            'pickup_district'   => $getDistrict($users[2]),
            'pickup_postal_code'=> $users[2]->profile->default_postal_code,
            'pickup_notes'      => 'Barang ada di security',
            'pickup_date'       => Carbon::now()->addDays(3),
            'pickup_time_slot'  => '09:00-13:00',
            'status'            => 'menunggu_penjemputan',
            'created_at'        => Carbon::now(),
        ]);

        DonationItem::create([
            'donation_id'    => $donation3->id,
            'gender'         => 'Laki-laki (Dewasa)',
            'item_category'  => 'Atasan',
            'quantity'       => 10,
            'condition'      => 'Layak pakai',
        ]);

        DonationItem::create([
            'donation_id'    => $donation3->id,
            'gender'         => 'Perempuan (Dewasa)',
            'item_category'  => 'Bawahan',
            'quantity'       => 8,
            'condition'      => 'Layak pakai',
        ]);

        DonationTracking::create([
            'donation_id'        => $donation3->id,
            'status'             => 'menunggu_penjemputan',
            'notes'              => 'Donasi berhasil dibuat, menunggu jadwal penjemputan',
            'status_changed_at'  => Carbon::now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | DONATION 4
        |--------------------------------------------------------------------------
        */
        $donation4 = Donation::create([
            'user_id'           => $users[3]->id,
            'campaign_id'       => $campaigns[3]->id,
            'donor_name'        => $users[3]->profile->full_name,
            'donor_phone'       => $users[3]->profile->phone_number,
            'donor_email'       => $users[3]->email,
            'pickup_address'    => $users[3]->profile->default_address,
            'pickup_province'   => $users[3]->profile->default_province,
            'pickup_city'       => $users[3]->profile->default_city,
            'pickup_district'   => $getDistrict($users[3]),
            'pickup_postal_code'=> $users[3]->profile->default_postal_code,
            'pickup_date'       => Carbon::tomorrow(),
            'pickup_time_slot'  => '13:00-17:00',
            'status'            => 'menunggu_penjemputan',
            'created_at'        => Carbon::now()->subDays(2),
        ]);

        DonationItem::create([
            'donation_id'    => $donation4->id,
            'gender'         => 'Laki-laki (Anak)',
            'item_category'  => 'Other',
            'quantity'       => 15,
            'condition'      => 'Baru',
        ]);

        DonationTracking::create([
            'donation_id'        => $donation4->id,
            'status'             => 'menunggu_penjemputan',
            'notes'              => 'Donasi berhasil dibuat',
            'status_changed_at'  => Carbon::now()->subDays(2),
        ]);

        $this->command->info('✅ Donations seeded successfully!');
    }
}
