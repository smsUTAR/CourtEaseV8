<?php

namespace App\Http\Controllers\Auth;

use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetTokenMail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwordForgot');
    }

    public function sendResetCode(Request $request)
    {
        // Validate the email address
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We couldn’t find an account with that email address.',
        ]);

        // Generate a short random code (letters/numbers)
        $verificationCode = Str::upper(Str::random(6)); // or use mt_rand(100000, 999999) for digits only

        // Hash the code
        $hashedCode = Hash::make($verificationCode);

        // Delete any existing tokens for this email
        PasswordReset::where('email', $request->email)->delete();

        // Store the code in the database for later verification
        // Optional: You may want to store the code with a timestamp to expire it after a while
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $hashedCode,
            'created_at' => now(),
        ]);

        // Send the email
        \Mail::to($request->email)->send(new ResetTokenMail($verificationCode));

        return redirect()->back()
        ->with('email', $request->email)
        ->with('step', 'verify-code')
        ->with('status', 'We have sent a reset code to your email.');
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->latest('created_at')
            ->first();

        if (!$record) {
            return redirect()->back()->withErrors(['code' => 'No reset request found for this email.']);
        }
        
        // Check if the code is expired (older than 10 minutes)
        if (now()->diffInMinutes($record->created_at) > 10) {
            return redirect()->back()->withErrors(['code' => 'This code has expired. Please request a new one.']);
        }
        
        // Check if the code matches
        if (!\Hash::check($request->code, $record->token)) {
            return redirect()->back()->withErrors(['code' => 'Invalid verification code.']);
        }

        // You can now redirect to the password reset form with token
        return redirect()->route('password.reset', ['token' => $request->code])
                        ->with('email', $request->email);
    }
}
