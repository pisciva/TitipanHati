<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Organization;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Tentukan batas waktu untuk periode saat ini dan sebelumnya
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // 1. STATS BULAN INI (CURRENT MONTH/CM)
        $cmActiveCampaigns = Campaign::where('status', 'aktif')->count();
        $cmTotalDonations = Donation::where('status', 'selesai')->count(); // Asumsi: Donasi Tersalurkan = status 'selesai'

        // 2. STATS BULAN LALU (LAST MONTH/LM)
        
        // Menghitung campaign aktif yang dibuat pada periode bulan lalu
        $lmActiveCampaigns = Campaign::where('status', 'aktif')
                                     ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                     ->count();
        
        // Menghitung Donasi Tersalurkan pada periode bulan lalu
        $lmTotalDonations = Donation::where('status', 'selesai')
                                    ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                    ->count();


        // 3. HITUNG PERSENTASE PERUBAHAN
        
        // Persentase Campaign Aktif (Active Campaigns)
        $activeChange = ($lmActiveCampaigns > 0) 
            ? (($cmActiveCampaigns - $lmActiveCampaigns) / $lmActiveCampaigns) * 100 
            : ($cmActiveCampaigns > 0 ? 100 : 0); // Jika sebelumnya 0 dan sekarang ada, anggap naik 100%

        // Persentase Donasi Tersalurkan (Total Donations)
        $donationChange = ($lmTotalDonations > 0) 
            ? (($cmTotalDonations - $lmTotalDonations) / $lmTotalDonations) * 100 
            : ($cmTotalDonations > 0 ? 100 : 0);


        $stats = [
            'total_campaigns' => Campaign::count(),
            'active_campaigns' => $cmActiveCampaigns,
            'total_donations' => $cmTotalDonations,
            'pending_pickups' => Donation::where('status', 'menunggu_penjemputan')->count(),
            'total_items' => \DB::table('donation_items')->sum('quantity'),
            'total_organizations' => Organization::where('is_verified', true)->count(),
            
            // TAMBAHKAN STATISTIK PERUBAHAN
            'active_campaign_change' => round($activeChange, 1),
            'total_donations_change' => round($donationChange, 1),
        ];


        $recentDonations = Donation::with(['user', 'campaign'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();


        $urgentCampaigns = Campaign::where('status', 'aktif')
            ->where('deadline', '<=', now()->addDays(7))
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard.admin.index', compact('stats', 'recentDonations', 'urgentCampaigns'));
    }
}