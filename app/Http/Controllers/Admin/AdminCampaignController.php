<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Organization;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Indonesia; 

class AdminCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }




    public function getCities($province_id)
    {


        $province = Indonesia::findProvince($province_id, ['cities']);
        

        return response()->json($province->cities);
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
        if ($request->filled('date_from')) {
            $query->whereDate('deadline', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('deadline', '<=', $request->date_to);
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.admin.campaigns.index', compact('campaigns'));
    }


    public function create()
    {
        $organizations = Organization::where('is_verified', true)->get();
        $categories = Category::all();


        $provinces = Indonesia::allProvinces(); 


        return view('dashboard.admin.campaigns.create', compact('organizations', 'categories', 'provinces'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            'province' => 'required|integer|min:1', 
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


        $provinceName = Indonesia::findProvince($request->province)->name;


        $campaign = Campaign::create([
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'description' => $request->description,
            'banner_url' => $bannerUrl,

            'province' => $provinceName, 
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


        $provinces = Indonesia::allProvinces();


        return view('dashboard.admin.campaigns.edit', compact('campaign', 'organizations', 'categories', 'provinces'));
    }


    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'province' => 'required|integer|min:1', 
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


        $provinceName = Indonesia::findProvince($request->province)->name;

        $campaign->update([
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'description' => $request->description,
            'province' => $provinceName, 
            'city' => $request->city,
            'target_quantity' => $request->target_quantity,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);


        $campaign->categories()->sync($request->categories);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);


        if ($campaign->donations()->count() > 0) {
            return back()->with(['error' => 'Campaign tidak dapat dihapus karena sudah ada donasi.']);
        }


        if ($campaign->banner_url) {
            Storage::disk('public')->delete($campaign->banner_url);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('deleted', 'Campaign berhasil dihapus!');
    }
}