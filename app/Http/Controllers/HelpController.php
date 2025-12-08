<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display the help page.
     */
    public function index()
    {
        // Return the view for the help page
        return view('help.index');
    }

    /**
     * Handle the contact form submission.
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Di sini Anda bisa kirim email, simpan ke DB, dll.
        // Contoh sederhana: hanya kembalikan pesan sukses
        return back()->with('success', 'Pesan Anda berhasil dikirim! Terima kasih.');
    }
}