<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Indonesia;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user profile page
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        

        $provinces = Indonesia::allProvinces();

        return view('dashboard.user.profile', compact('user', 'profile', 'provinces'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'default_address' => 'nullable|string',
            'default_province' => 'nullable|string|max:100',
            'default_city' => 'nullable|string|max:100',
            'default_district' => 'nullable|string|max:100',
            'default_postal_code' => 'nullable|string|max:10',
            'default_notes' => 'nullable|string',
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
                'default_district',
                'default_postal_code',
                'default_notes'
            ])
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Display donation history
     */
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

        $donations = $query->paginate(10);

        return view('dashboard.user.riwayat', compact('donations', 'status'));
    }

    /**
     * Get cities by province ID (API endpoint)
     */
    public function getCities($provinceId)
    {
        try {
            $province = Indonesia::findProvince($provinceId, ['cities']);
            $cities = $province->cities->map(function($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name
                ];
            });
            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Error loading cities: ' . $e->getMessage());
            return response()->json(['error' => 'Province not found'], 404);
        }
    }

    /**
     * Get districts by city ID (API endpoint)
     */
    public function getDistricts($cityId)
    {
        try {
            $city = Indonesia::findCity($cityId, ['districts']);
            $districts = $city->districts->map(function($district) {
                return [
                    'id' => $district->id,
                    'name' => $district->name
                ];
            });
            return response()->json($districts);
        } catch (\Exception $e) {
            Log::error('Error loading districts: ' . $e->getMessage());
            return response()->json(['error' => 'City not found'], 404);
        }
    }
}