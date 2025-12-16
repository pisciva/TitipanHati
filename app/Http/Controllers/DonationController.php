<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\DonationTracking;
use App\Models\Campaign;
use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Indonesia;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProvinces($provinceId)
    {
        try {
            $province = Indonesia::findProvince($provinceId, ['cities']);
            $cities = $province->cities->map(fn($city) => ['id' => $city->id, 'name' => $city->name]);
            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Error loading cities: ' . $e->getMessage());
            return response()->json(['error' => 'Province not found'], 404);
        }
    }

    public function getCities($cityId)
    {
        try {
            $city = Indonesia::findCity($cityId, ['districts']);
            $districts = $city->districts->map(fn($district) => ['id' => $district->id, 'name' => $district->name]);
            return response()->json($districts);
        } catch (\Exception $e) {
            Log::error('Error loading districts: ' . $e->getMessage());
            return response()->json(['error' => 'City not found'], 404);
        }
    }

    public function create($campaignId)
    {
        $campaign = Campaign::with('organization')->findOrFail($campaignId);
        $user = Auth::user();
        $profile = $user->profile;
        $provinces = Indonesia::allProvinces();

        return view('donations.create', compact('campaign', 'profile', 'provinces'));
    }

    public function store(StoreDonationRequest $request)
    {
        Log::info('=== DONATION FORM SUBMITTED ===');
        Log::info('All Request Data:', $request->all());

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'campaign_id' => $validated['campaign_id'],
                'donor_name' => $validated['donor_name'],
                'donor_phone' => $validated['donor_phone'],
                'donor_email' => $validated['donor_email'],
                'pickup_address' => $validated['pickup_address'],
                'pickup_province' => $validated['pickup_province'],
                'pickup_city' => $validated['pickup_city'],
                'pickup_district' => $validated['pickup_district'],
                'pickup_postal_code' => $validated['pickup_postal_code'],
                'pickup_notes' => $validated['pickup_notes'] ?? null,
                'pickup_date' => $validated['pickup_date'],
                'pickup_time_slot' => $validated['pickup_time_slot'],
                'status' => 'menunggu_penjemputan',
            ]);

            Log::info('Donation created with ID: ' . $donation->id);

            foreach ($validated['items'] as $item) {
                DonationItem::create([
                    'donation_id' => $donation->id,
                    'gender' => $item['gender'],
                    'item_category' => $item['item_category'],
                    'quantity' => $item['quantity'],
                    'condition' => $item['condition'],
                    'photo_url' => null,
                ]);
            }

            Log::info('Donation items created: ' . count($validated['items']));

            DonationTracking::create([
                'donation_id' => $donation->id,
                'status' => 'menunggu_penjemputan',
                'notes' => 'Donasi berhasil dibuat',
                'status_changed_at' => now(),
            ]);

            Log::info('Donation tracking created');

            EmailLog::create([
                'donation_id' => $donation->id,
                'user_id' => Auth::id(),
                'email_to' => $validated['donor_email'],
                'email_type' => 'konfirmasi_donasi',
                'email_content' => 'Email konfirmasi donasi',
                'is_sent' => false,
            ]);

            Log::info('Email log created');

            DB::commit();
            Log::info('=== DONATION SUCCESS ===');

            return redirect()
                ->route('donations.success', $donation->id)
                ->with('success', 'Donasi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('=== DONATION FAILED ===');
            Log::error('Error Message: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());

            if ($e instanceof \Illuminate\Database\QueryException) {
                Log::error('Database Query Exception: ' . $e->getMessage());
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                Log::error('Model Validation Exception: ' . $e->getMessage());
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan donasi. Silakan coba lagi atau hubungi admin jika masalah berlanjut.');
        }
    }

    public function success($id)
    {
        $donation = Donation::with(['campaign', 'items'])->findOrFail($id);

        if ($donation->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('donations.success', compact('donation'));
    }

    public function myDonations()
    {
        $donations = Donation::with(['campaign', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.user.riwayat', compact('donations'));
    }

    public function show($id)
    {
        $donation = Donation::with(['campaign', 'items', 'tracking'])
            ->findOrFail($id);

        if ($donation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke donasi ini.');
        }

        return view('dashboard.user.detail', compact('donation'));
    }
}