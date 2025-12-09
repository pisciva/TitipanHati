<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\AdminDonationController;


// ================================
// Public Routes
// ================================
Route::get('/', [CampaignController::class, 'homepage'])->name('home');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

Route::get('/help', [HelpController::class, 'index'])->name('help.index');

// Contact Form
Route::post('/contact', [HelpController::class, 'send'])->name('contact.send');


// ================================
// Guest Routes (Login / Register / Reset Password)
// ================================
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google OAuth
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // Password Reset
    Route::get('/password/reset', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/update', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});


// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ================================
// User Authenticated Routes
// ================================
Route::middleware('auth')->group(function () {

    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    // Riwayat Donasi User
    Route::get('/profile/riwayat', [ProfileController::class, 'riwayat'])->name('profile.riwayat');

    // Donasi
    Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/success/{id}', [DonationController::class, 'success'])->name('donations.success');
    Route::get('/my-donations', [DonationController::class, 'myDonations'])->name('donations.history');
    Route::get('/donations/{id}', [DonationController::class, 'show'])->name('donations.show');

    // API untuk mengambil kota berdasarkan provinsi (digunakan di form donasi)
    Route::get('/api/cities/{provinceId}', [DonationController::class, 'getProvinces'])->name('api.cities');
    // API untuk mengambil kecamatan berdasarkan kota (digunakan di form donasi)
    Route::get('/api/districts/{cityId}', [DonationController::class, 'getCities'])->name('api.districts');
});


// ================================
// Admin Routes
// ================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    

    Route::resource('campaigns', AdminCampaignController::class);
    Route::get('campaigns/get-cities/{province_id}', [AdminCampaignController::class, 'getCities'])->name('campaigns.getCities');

    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    
    Route::put('/donations/{id}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.updateStatus');
    

    Route::get('/donations/calendar', [AdminDonationController::class, 'calendar'])->name('donations.calendar');
    Route::get('/donations/by-date', [AdminDonationController::class, 'getByDate'])->name('donations.byDate');
    

    Route::get('/donations/export', [AdminDonationController::class, 'export'])->name('donations.export');
    Route::get('/donations/{id}', [AdminDonationController::class, 'show'])->name('donations.show');
});