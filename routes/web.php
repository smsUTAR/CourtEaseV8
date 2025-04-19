<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

Route::get('/account', [AuthController::class, 'showAccount'])->name('account')->middleware('auth');
Route::post('/account/update-password', [AuthController::class, 'updatePassword'])->name('account.updatePassword')->middleware('auth');

Route::post('/account/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
