<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourtController;

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

Route::get('/admin', function () {
    return view('admin_panel');
})->name('admin');

Route::get('/admin-adjust-pricing', [CourtController::class, 'showChangePriceForm'])->name('courts.changePrice');
Route::post('/admin-adjust-pricing', [CourtController::class, 'updateAllPrices'])->name('courts.updatePrice');


Route::get('/admin-court', [CourtController::class,'showCourtName']);
Route::post('/courts/update-status', [CourtController::class, 'updateStatus'])->name('courts.updateStatus');
