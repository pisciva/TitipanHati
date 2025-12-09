<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignView;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{

    public function index(Request $request)
    {
        $query = Campaign::with(['organization', 'categories']);

        // Search - Search in title, description, and organization name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhereHas('organization', function ($orgQuery) use ($searchTerm) {
                        $orgQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Province - Filter berdasarkan ID provinsi
        if ($request->filled('province')) {
            $provinceId = $request->province;
            
            // Query langsung ke tabel provinces (Laravolt)
            $province = DB::table('indonesia_provinces')->where('id', $provinceId)->first();
            
            if ($province) {
                $query->where('province', $province->name);
            }
        }

        // City - Filter berdasarkan nama kota
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Sorting
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'trending':
                $query->orderBy('view_count', 'desc');
                break;
            case 'deadline_soon':
                $query->orderBy('deadline', 'asc');
                break;
            case 'progress_high':
                $query->orderByRaw('(collected_quantity * 1.0 / NULLIF(target_quantity, 1)) DESC');
                break;
            case 'progress_low':
                $query->orderByRaw('(collected_quantity * 1.0 / NULLIF(target_quantity, 1)) ASC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $campaigns = $query->paginate(9);
        $campaigns->appends($request->query());

        // Ambil data provinces dari Laravolt (langsung query DB)
        $provinces = DB::table('indonesia_provinces')->orderBy('name')->get();

        return view('campaigns.index', compact('campaigns', 'provinces'));
    }


    public function show($id)
    {
        $campaign = Campaign::with(['organization', 'categories', 'donations'])
            ->findOrFail($id);

        // Increment view count dengan proteksi 24 jam per IP
        $this->trackView($campaign);

        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Track campaign view dengan proteksi spam menggunakan database
     */
    protected function trackView(Campaign $campaign)
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        $userId = auth()->id();

        // Cek apakah IP ini sudah view dalam 24 jam terakhir
        $recentView = CampaignView::where('campaign_id', $campaign->id)
            ->where('ip_address', $ipAddress)
            ->where('viewed_at', '>', now()->subDay())
            ->first();

        // Jika belum ada view dalam 24 jam, catat view baru
        if (!$recentView) {
            // Simpan record view
            CampaignView::create([
                'campaign_id' => $campaign->id,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'user_id' => $userId,
                'viewed_at' => now(),
            ]);

            // Increment view_count di campaign
            $campaign->increment('view_count');

            // Optional: Log untuk debugging
            \Log::info("Campaign view tracked", [
                'campaign_id' => $campaign->id,
                'ip' => $ipAddress,
                'new_view_count' => $campaign->fresh()->view_count
            ]);
        }
    }


    public function homepage()
    {
        $newest = Campaign::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $trending = Campaign::where('status', 'aktif')
            ->orderBy('view_count', 'desc')
            ->limit(3)
            ->get();

        $statistics = [
            'total_items' => DB::table('donation_items')->sum('quantity'),
            'active_campaigns' => Campaign::where('status', 'aktif')->count(),
            'total_organizations' => DB::table('organizations')->where('is_verified', true)->count(),
        ];

        $testimonials = \App\Models\Testimonial::where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();

        return view('home', compact('newest', 'trending', 'statistics', 'testimonials'));
    }
}