<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationTracking;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class AdminDonationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function index(Request $request)
    {
        $query = Donation::with(['user', 'campaign']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($r) use ($searchTerm) {
                      $r->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }


        if ($request->filled('date_from')) {

            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {

            $query->whereDate('created_at', '<=', $request->date_to);
        }



        $donations = $query->orderBy('pickup_date', 'desc')->paginate(20);
        $campaigns = Campaign::all();

        return view('dashboard.admin.donation.index', compact('donations', 'campaigns'));
    }


    public function show($id)
    {
        $donation = Donation::with(['user', 'campaign', 'items', 'tracking'])
            ->findOrFail($id);

        return view('dashboard.admin.donation.show', compact('donation'));
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu_penjemputan,dalam_perjalanan,selesai,dibatalkan',
            'notes' => 'nullable|string',
        ]);

        $donation = Donation::findOrFail($id);
        $oldStatus = $donation->status;


        $donation->update(['status' => $request->status]);


        DonationTracking::create([
            'donation_id' => $donation->id,
            'status' => $request->status,
            'notes' => $request->notes ?? "Status diubah dari {$oldStatus} menjadi {$request->status}",
            'status_changed_at' => now(),
        ]);


        if ($request->status === 'selesai') {
            $campaign = $donation->campaign;
            $totalQuantity = $donation->items->sum('quantity');
            $campaign->increment('collected_quantity', $totalQuantity);


            if ($campaign->collected_quantity >= $campaign->target_quantity) {
                $campaign->update(['status' => 'selesai']);
            }
        }



        return back()->with('success', 'Status donasi berhasil diupdate!');
    }


    public function calendar(Request $request)
    {

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);


        $donations = Donation::whereYear('pickup_date', $year)
            ->whereMonth('pickup_date', $month)
            ->with(['user', 'campaign'])
            ->get()
            ->groupBy(function($donation) {
                return $donation->pickup_date->format('Y-m-d');
            });

        return view('dashboard.admin.donation.calendar', compact('donations', 'month', 'year'));
    }


    public function getByDate(Request $request)
    {
        $date = $request->get('date');
        
        $donations = Donation::whereDate('pickup_date', $date)
            ->with(['user', 'campaign', 'items'])
            ->get();

        return response()->json($donations);
    }


    public function export(Request $request)
    {

        $query = Donation::with(['user', 'campaign', 'items']);


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($r) use ($searchTerm) {
                      $r->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }


        $donations = $query->orderBy('created_at', 'desc')->get();


        $filename = 'donasi-barang-export-' . Carbon::now()->format('Ymd_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];


        $columns = [
            'ID Donasi',
            'Tgl. Dibuat',
            'Donatur',
            'Email Donatur',
            'Nomor Kontak',
            'Campaign Tujuan',
            'Status',
            'Tgl. Penjemputan',
            'Alamat Penjemputan',
            'Barang Didonasikan (Kategori & Kuantitas)',
        ];

        $callback = function() use ($donations, $columns)
        {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, $columns, ';'); 

            foreach ($donations as $donation) {
                $itemsDetail = $donation->items->map(function ($item) {
                    return "{$item->item_category} ({$item->quantity}x)";
                })->implode(', ');

                $row = [
                    $donation->id,
                    $donation->created_at->format('Y-m-d H:i:s'),
                    $donation->user->name ?? 'Anonim',
                    $donation->user->email ?? '-',
                    $donation->donor_phone,
                    $donation->campaign->title ?? 'Campaign Dihapus',
                    ucfirst(str_replace('_', ' ', $donation->status)),
                    $donation->pickup_date->format('Y-m-d'),
                    $donation->pickup_address, 
                    $itemsDetail,
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }
}