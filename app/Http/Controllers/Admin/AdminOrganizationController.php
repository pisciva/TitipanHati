<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminOrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Organization::query();

        if ($request->filled('is_verified')) {
            $query->where('is_verified', $request->is_verified == 'true');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $organizations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.admin.organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('dashboard.admin.organization.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
            'description' => 'nullable|string',
            'contact_email' => 'required|email|max:255|unique:organizations,contact_email',
            'contact_phone' => 'nullable|string|max:15',
            'address' => 'required|string|max:500',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_verified' => 'required|boolean', 
        ]);

        $logoUri = null;
        if ($request->hasFile('logo_url')) {
            $logoUri = $request->file('logo_url')->store('organizations/logos', 'public');
        }

        Organization::create([
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'address' => $request->address,
            'logo_url' => $logoUri,
            'is_verified' => $request->is_verified,
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil dibuat!');
    }

    public function show($id)
    {
        $organization = Organization::with('campaigns')->findOrFail($id);

        return view('dashboard.admin.organization.show', compact('organization'));
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);

        return view('dashboard.admin.organization.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $id,
            'description' => 'nullable|string',
            'contact_email' => 'required|email|max:255|unique:organizations,contact_email,' . $id,
            'contact_phone' => 'nullable|string|max:15',
            'address' => 'required|string|max:500',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_verified' => 'required|boolean',
        ]);

        if ($request->hasFile('logo_url')) {
            if ($organization->logo_url) {
                Storage::disk('public')->delete($organization->logo_url);
            }
            $logoUri = $request->file('logo_url')->store('organizations/logos', 'public');
        } else {
            $logoUri = $organization->logo_url;
        }

        $organization->update([
            'name' => $request->name,
            'description' => $request->description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'address' => $request->address,
            'logo_url' => $logoUri,
            'is_verified' => $request->is_verified,
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);

        if ($organization->campaigns()->count() > 0) {
            return back()->with(['error' => 'Organisasi tidak dapat dihapus karena masih memiliki Campaign.']);
        }

        if ($organization->logo_url) {
            Storage::disk('public')->delete($organization->logo_url);
        }

        $organization->delete();

        return redirect()->route('admin.organizations.index')
            ->with('deleted', 'Organisasi berhasil dihapus!');
    }

    public function toggleVerification($id)
    {
        $organization = Organization::findOrFail($id);
        
        $organization->is_verified = !$organization->is_verified;
        $organization->save();

        $status = $organization->is_verified ? 'terverifikasi' : 'belum terverifikasi';

        return back()->with('success', "Status verifikasi organisasi '{$organization->name}' berhasil diubah menjadi {$status}.");
    }
}