<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function index(Request $request)
    {
        $query = Campaign::with(['organization', 'categories']); // Tambahkan relasi jika perlu

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

        // Province
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        // City
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

        $campaigns = $query->paginate(9); // 9 items per page
        $campaigns->appends($request->query()); // Untuk pagination dengan query string

        return view('campaigns.index', compact('campaigns'));
    }


    public function show($id)
    {
        $campaign = Campaign::with(['organization', 'categories', 'donations'])
            ->findOrFail($id);


        $campaign->increment('view_count');

        return view('campaigns.show', compact('campaign'));
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
