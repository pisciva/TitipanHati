<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('profile.index', compact('user', 'profile'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'default_address' => 'nullable|string',
            'default_province' => 'nullable|string|max:100',
            'default_city' => 'nullable|string|max:100',
            'default_postal_code' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();
        

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'full_name',
                'phone_number',
                'default_address',
                'default_province',
                'default_city',
                'default_postal_code',
                'default_notes'
            ])
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();

        $status = $request->get('status');

        $query = Donation::with(['campaign', 'items'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $donations = $query->paginate(5);

        return view('dashboard.user.riwayat', compact('donations', 'status'));
    }
}