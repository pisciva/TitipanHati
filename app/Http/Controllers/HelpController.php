<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {

        return view('help.index');
    }
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);



        return back()->with('success', 'Pesan Anda berhasil dikirim! Terima kasih.');
    }
}