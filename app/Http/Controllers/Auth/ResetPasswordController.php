<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PasswordReset;
use App\Traits\ValidationRules;
use App\Traits\ValidationMessages;

class ResetPasswordController extends Controller
{
    use ValidationRules, ValidationMessages;

    public function showResetForm(Request $request, $token)
    {
        $record = DB::table('password_resets')
            ->latest('created_at')
            ->get()
            ->first(function ($r) use ($token) {
                return Hash::check($token, $r->token);
            });

        if (!$record) {
            return redirect()->back()->withErrors(['code' => 'Invalid or expired token.']);
        }

        if (now()->diffInMinutes($record->created_at) > 10) {
            return redirect()->back()->withErrors(['code' => 'This code has expired. Please request a new one.']);
        }

        return view('auth.passwordReset', [
            'token' => $token,
            'email' => $record->email,
        ]);
    }

    public function reset(Request $request)
    {
        $customMessages = array_merge(
            $this->emailMessages(),
            $this->passwordMessages()
        );

        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => array_merge(
                ['required', 'confirmed'],
                $this->passwordRules()
            ),
        ], $customMessages);

        $record = PasswordReset::where('email', $request->email)
            ->latest('created_at')
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        if (now()->diffInMinutes($record->created_at) > 10) {
            return back()->withErrors(['email' => 'Token has expired.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been successfully reset.');
    }
}
