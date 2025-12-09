<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {

        $query = Campaign::with(['organization', 'categories'])
            ->where('status', 'aktif');


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('organization', fn($org) => $org->where('name', 'like', "%{$search}%"));
            });
        }


        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }


        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }


        if ($request->filled('category')) {
            $query->whereHas('categories', fn($cat) => $cat->where('id', $request->category));
        }


        if ($request->filled('sort')) {
            match ($request->sort) {
                'trending' => $query->orderBy('view_count', 'desc'),
                'newest'   => $query->orderBy('created_at', 'desc'),
                default    => $query->orderBy('created_at', 'desc'),
            };
        } else {
            $query->orderBy('created_at', 'desc');
        }


        $campaigns = $query->paginate(12);
        $categories = Category::all();


        $provinces = DB::table(config('laravolt.indonesia.table_prefix') . 'provinces')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();


        return view('campaigns.index', compact('campaigns', 'categories', 'provinces'));
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