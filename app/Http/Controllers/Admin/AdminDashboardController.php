<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Organization;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {

        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();


        $cmActiveCampaigns = Campaign::where('status', 'aktif')->count();
        $cmTotalDonations = Donation::where('status', 'selesai')->count(); 


        

        $lmActiveCampaigns = Campaign::where('status', 'aktif')
                                     ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                     ->count();
        

        $lmTotalDonations = Donation::where('status', 'selesai')
                                    ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                    ->count();



        

        $activeChange = ($lmActiveCampaigns > 0) 
            ? (($cmActiveCampaigns - $lmActiveCampaigns) / $lmActiveCampaigns) * 100 
            : ($cmActiveCampaigns > 0 ? 100 : 0);


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