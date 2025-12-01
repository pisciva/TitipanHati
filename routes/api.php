<?php

use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\CampaignController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('api')->group(function () {

    Route::get('/campaigns', [CampaignController::class, 'index']);
    

    Route::middleware('auth')->get('/donations/by-date', [AdminDonationController::class, 'getByDate']);
});