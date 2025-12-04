<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Organization;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_campaigns' => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'aktif')->count(),
            'total_donations' => Donation::count(),
            'pending_pickups' => Donation::where('status', 'menunggu_penjemputan')->count(),
            'total_items' => \DB::table('donation_items')->sum('quantity'),
            'total_organizations' => Organization::where('is_verified', true)->count(),
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