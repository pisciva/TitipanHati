<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'donatur',
            'is_verified' => false,
        ]);


        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {

                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {

                $user = User::create([
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()), // Random password
                    'google_id' => $googleUser->id,
                    'role' => 'donatur',
                    'is_verified' => true,
                    'email_verified_at' => now(),
                ]);


                UserProfile::create([
                    'user_id' => $user->id,
                    'full_name' => $googleUser->name,
                    'phone_number' => '', // Will be filled later
                ]);
            }

            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}