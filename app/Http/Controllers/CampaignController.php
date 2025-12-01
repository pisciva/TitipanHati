<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function index(Request $request)
    {
        $query = Campaign::with(['organization', 'categories'])
            ->where('status', 'aktif');


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('organization', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }


        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }


        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }


        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }


        if ($request->filled('sort')) {
            if ($request->sort === 'trending') {
                $query->orderBy('view_count', 'desc');
            } elseif ($request->sort === 'newest') {
                $query->orderBy('created_at', 'desc');
            }
        } else {

            $query->orderBy('created_at', 'desc');
        }

        $campaigns = $query->paginate(12);
        $categories = Category::all();

        return view('campaigns.index', compact('campaigns', 'categories'));
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
