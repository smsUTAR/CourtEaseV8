<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CourtController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/account', function () {
    return view('account');
})->name('account');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/passwordForgot', function () { return view('/auth/passwordForgot');})->name('passwordForgot');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::post('/sendResetCode', [ForgotPasswordController::class, 'sendResetCode'])->name('sendResetCode');
Route::post('/verifyResetCode', [ForgotPasswordController::class, 'verifyResetCode'])->name('verifyResetCode');

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');

Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'adminRegister']);


Route::middleware('auth')->group(function () {
Route::get('/account', [AuthController::class, 'showAccount'])->name('account')->middleware('auth');
Route::post('/account/update-password', [AuthController::class, 'updatePassword'])->name('account.updatePassword')->middleware('auth');

Route::post('/account/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');

Route::get('/court/{id}', [CourtController::class, 'courtDetails'])->name('court-details')->middleware('check.court.availability','block-payment-revisit');
Route::get('/check-availability', [BookingController::class, 'checkAvailability'])->name('check.availability');

Route::get('/court-listing', [CourtController::class, 'showListing'])->name('court-listing');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');


Route::post('/payment', [CourtController::class, 'showPayment'])
->name('payment')
->middleware('block-payment-revisit');

Route::post('/process-payment', [BookingController::class, 'processPayment'])
->name('process-payment');
Route::get('/booking-confirmation/{booking}', [BookingController::class, 'showConfirmation'])
->name('booking-confirmation');

Route::get('contact', function() {
    return view('contact');
})->name('contact');

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/admin', function () {
    return view('admin_panel');
})->name('admin');

Route::get('/admin-adjust-pricing', [CourtController::class, 'showChangePriceForm'])->name('courts.changePrice');
Route::post('/admin-adjust-pricing', [CourtController::class, 'updateAllPrices'])->name('courts.updatePrice');


Route::get('/admin-court', [CourtController::class,'showCourtName']);
Route::post('/courts/update-status', [CourtController::class, 'updateStatus'])->name('courts.updateStatus');

Route::get('admin-court/create', [CourtController::class, 'createNewCourt'])->name('admin.court.create');
Route::post('admin-court', [CourtController::class, 'storeNewCourt'])->name('admin.court.store');

Route::get('/admin-court-manage', [CourtController::class, 'showManageCourt'])->name('admin-court-manage.showManageCourt');
Route::get('/admin-court-manage/{id}/edit', [CourtController::class, 'editCourt'])->name('admin-court-manage.editCourt');
Route::put('/admin-court-manage/{id}', [CourtController::class, 'updateCourt'])->name('admin-court-manage.updateCourt');
Route::delete('/admin-court-manage/{id}', [CourtController::class, 'destroyCourt'])->name('admin-court-manage.destroyCourt');
Route::get('/admin-booked-courts', [CourtController::class, 'bookedCourts'])->name('admin-booked-courts');


});


});
