<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();


        $stats = [
            'total_donations' => Donation::where('user_id', $user->id)->count(),
            'total_items' => Donation::where('user_id', $user->id)
                ->join('donation_items', 'donations.id', '=', 'donation_items.donation_id')
                ->sum('donation_items.quantity'),
            'active_donations' => Donation::where('user_id', $user->id)
                ->whereIn('status', ['menunggu_penjemputan', 'dalam_perjalanan'])
                ->count(),
        ];


        $recentDonations = Donation::with(['campaign', 'items'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.user.index', compact('stats', 'recentDonations'));
    }
}