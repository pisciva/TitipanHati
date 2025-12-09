<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\DonationTracking;
use App\Models\Campaign;
use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Indonesia; // ⭐ Tambahan untuk Laravolt Indonesia

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ⭐ BARU: API untuk mendapatkan daftar kota berdasarkan provinsi
     */
    public function getCities($provinceId)
    {
        try {
            $province = Indonesia::findProvince($provinceId, ['cities']);
            return response()->json($province->cities);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Province not found'], 404);
        }
    }

    /**
     * ⭐ BARU: API untuk mendapatkan daftar kecamatan berdasarkan kota
     */
    public function getDistricts($cityId)
    {
        try {
            $city = Indonesia::findCity($cityId, ['districts']);
            return response()->json($city->districts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'City not found'], 404);
        }
    }

    public function create($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        $user = Auth::user();
        $profile = $user->profile;
        
        // ⭐ Tambahan: Kirim data provinsi ke view
        $provinces = Indonesia::allProvinces();

        return view('donations.create', compact('campaign', 'profile', 'provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:20',
            'donor_email' => 'required|email',
            'pickup_address' => 'required|string',
            // ⭐ Perubahan: Terima ID provinsi, kota, dan kecamatan
            'pickup_province' => 'required|integer',
            'pickup_city' => 'required|integer',
            'pickup_district' => 'required|integer',
            'pickup_postal_code' => 'required|string|max:10',
            'pickup_date' => 'required|date|after:+2 days', // Min 3 days from now
            'pickup_time_slot' => 'required|in:09:00-13:00,13:00-17:00',
            'items' => 'required|array|min:1',
            'items.*.gender' => 'required|in:Laki-laki (Anak),Perempuan (Anak),Laki-laki (Dewasa),Perempuan (Dewasa)',
            'items.*.item_category' => 'required|in:Atasan,Bawahan,Other',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.condition' => 'required|in:Baru,Layak pakai,Tidak layak',
        ]);

        DB::beginTransaction();
        try {
            // ⭐ Konversi ID menjadi nama untuk disimpan
            $provinceName = Indonesia::findProvince($request->pickup_province)->name;
            $cityName = Indonesia::findCity($request->pickup_city)->name;
            $districtName = Indonesia::findDistrict($request->pickup_district)->name;

            $donation = Donation::create([
                'user_id' => Auth::id(),
                'campaign_id' => $request->campaign_id,
                'donor_name' => $request->donor_name,
                'donor_phone' => $request->donor_phone,
                'donor_email' => $request->donor_email,
                'pickup_address' => $request->pickup_address,
                // ⭐ Simpan nama, bukan ID
                'pickup_city' => $cityName,
                'pickup_district' => $districtName,
                'pickup_postal_code' => $request->pickup_postal_code,
                'pickup_notes' => $request->pickup_notes,
                'pickup_date' => $request->pickup_date,
                'pickup_time_slot' => $request->pickup_time_slot,
                'status' => 'menunggu_penjemputan',
            ]);

            foreach ($request->items as $item) {
                DonationItem::create([
                    'donation_id' => $donation->id,
                    'gender' => $item['gender'],
                    'item_category' => $item['item_category'],
                    'quantity' => $item['quantity'],
                    'condition' => $item['condition'],
                    'photo_url' => $item['photo_url'] ?? null,
                ]);
            }

            DonationTracking::create([
                'donation_id' => $donation->id,
                'status' => 'menunggu_penjemputan',
                'notes' => 'Donasi berhasil dibuat',
                'status_changed_at' => now(),
            ]);

            EmailLog::create([
                'donation_id' => $donation->id,
                'user_id' => Auth::id(),
                'email_to' => $request->donor_email,
                'email_type' => 'konfirmasi_donasi',
                'email_content' => 'Email konfirmasi donasi',
                'is_sent' => false,
            ]);

            DB::commit();

            return redirect()->route('donations.success', $donation->id)
                ->with('success', 'Donasi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function success($id)
    {
        $donation = Donation::with(['campaign', 'items'])->findOrFail($id);
        
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('donations.success', compact('donation'));
    }

    public function myDonations()
    {
        $donations = Donation::with(['campaign', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.user.riwayat', compact('donations'));
    }

    public function show($id)
    {
        $donation = Donation::with(['campaign', 'items', 'tracking'])
            ->findOrFail($id);

        if ($donation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }        
        
        return view('dashboard.user.donationsHistory', compact('donation'));
    }
}