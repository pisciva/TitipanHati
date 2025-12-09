<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function index(Request $request)
    {
        $query = Campaign::with(['organization', 'categories']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhereHas('organization', function ($orgQuery) use ($searchTerm) {
                        $orgQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Province - Filter berdasarkan ID provinsi
        if ($request->filled('province')) {
            $provinceId = $request->province;
            
            // Query langsung ke tabel provinces (Laravolt)
            $province = \DB::table('provinces')->where('id', $provinceId)->first();
            
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
                $query->orderByRaw('(collected_quantity * 1.0 / target_quantity) DESC');
                break;
            case 'progress_low':
                $query->orderByRaw('(collected_quantity * 1.0 / target_quantity) ASC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $campaigns = $query->paginate(9);
        $campaigns->appends($request->query());

        // Ambil data provinces dari Laravolt (langsung query DB)
        $provinces = \DB::table('provinces')->orderBy('name')->get();

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
     * Track campaign view dengan proteksi spam
     */
    protected function trackView(Campaign $campaign)
    {
        $cacheKey = 'campaign_' . $campaign->id . '_ip_' . request()->ip();
        
        // Cek apakah IP ini sudah view dalam 24 jam
        if (!cache()->has($cacheKey)) {
            // Increment view count
            $campaign->increment('view_count');
            
            // Lock selama 24 jam
            cache()->put($cacheKey, true, now()->addDay());
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
            'total_items' => \DB::table('donation_items')->sum('quantity'),
            'active_campaigns' => Campaign::where('status', 'aktif')->count(),
            'total_organizations' => \DB::table('organizations')->where('is_verified', true)->count(),
        ];

        $testimonials = \App\Models\Testimonial::where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();

        return view('home', compact('newest', 'trending', 'statistics', 'testimonials'));
    }
}