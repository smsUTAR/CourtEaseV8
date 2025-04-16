<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/account', function () {
    return view('account');
})->name('account');

Route::get('/court/{id}', function ($id) {
    return view('court-details', ['id' => $id]);
})->name('court-details');

Route::get('/', function () {
    return view('court-listing');
})->name('court-listing');

Route::get('/payment/{court}', [BookingController::class, 'showPayment'])
->name('payment')
->middleware('auth');