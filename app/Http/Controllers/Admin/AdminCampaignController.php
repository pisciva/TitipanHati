<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Organization;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function index(Request $request)
    {
        $query = Campaign::with('organization');


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.admin.campaigns.index', compact('campaigns'));
    }


    public function create()
    {
        $organizations = Organization::where('is_verified', true)->get();
        $categories = Category::all();

        return view('dashboard.admin.campaigns.create', compact('organizations', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'target_quantity' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);


        $bannerUrl = null;
        if ($request->hasFile('banner')) {
            $bannerUrl = $request->file('banner')->store('campaigns', 'public');
        }


        $campaign = Campaign::create([
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'description' => $request->description,
            'banner_url' => $bannerUrl,
            'province' => $request->province,
            'city' => $request->city,
            'target_quantity' => $request->target_quantity,
            'deadline' => $request->deadline,
            'status' => 'aktif',
        ]);


        $campaign->categories()->attach($request->categories);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil dibuat!');
    }


    public function show($id)
    {
        $campaign = Campaign::with(['organization', 'categories', 'donations.items'])
            ->findOrFail($id);

        return view('dashboard.admin.campaigns.show', compact('campaign'));
    }


    public function edit($id)
    {
        $campaign = Campaign::with('categories')->findOrFail($id);
        $organizations = Organization::where('is_verified', true)->get();
        $categories = Category::all();

        return view('dashboard.admin.campaigns.edit', compact('campaign', 'organizations', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'target_quantity' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'status' => 'required|in:aktif,selesai',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);


        if ($request->hasFile('banner')) {

            if ($campaign->banner_url) {
                Storage::disk('public')->delete($campaign->banner_url);
            }
            $campaign->banner_url = $request->file('banner')->store('campaigns', 'public');
        }


        $campaign->update([
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'description' => $request->description,
            'province' => $request->province,
            'city' => $request->city,
            'target_quantity' => $request->target_quantity,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);


        $campaign->categories()->sync($request->categories);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil diupdate!');
    }


    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);


        if ($campaign->donations()->count() > 0) {
            return back()->withErrors(['error' => 'Campaign tidak dapat dihapus karena sudah ada donasi.']);
        }


        if ($campaign->banner_url) {
            Storage::disk('public')->delete($campaign->banner_url);
        }

        $campaign->delete();

        return redirect()->route('dashboard.admin.campaigns.index')
            ->with('success', 'Campaign berhasil dihapus!');
    }
}