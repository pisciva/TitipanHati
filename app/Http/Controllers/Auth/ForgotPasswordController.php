<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);


        $token = Str::random(64);


        DB::table('password_resets')->where('email', $request->email)->delete();


        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(30),
            'created_at' => Carbon::now()
        ]);




        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }


    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);


        $passwordReset = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }


        if (Carbon::parse($passwordReset->expires_at)->isPast()) {
            return back()->withErrors(['email' => 'Token sudah kadaluarsa.']);
        }


        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);


        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}