<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ValidationRules;
use App\Traits\ValidationMessages;

class AuthController extends Controller
{
    use ValidationMessages;
    use ValidationRules;

    // Show Login View
    public function showLogin(Request $request)
    {
        // If user already logged in, redirect based on role
        if (Auth::check()) {
            $user = Auth::user();
            return redirect()->route($user->is_admin ? 'admin' : 'court-listing');
        }
    
        $isAdmin = $request->routeIs('admin.login');
    
        return view('auth.login', [
            'isAdmin' => $isAdmin,
            'registerRoute' => $isAdmin ? route('admin.register') : route('register'),
            'loginAction' => route($isAdmin ? 'admin.login' : 'login'),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput();
        }

        // Attempt login manually since we already checked credentials
        Auth::login($user, $request->has('remember'));

        session(['welcome_message' => 'Welcome back, ' . $user->name]);
        session(['is_admin' => $user->is_admin]);

        if ($user->is_admin) {
            return redirect()->route('admin')->with('success', 'Admin logged in successfully!');
        } else {
            return redirect()->route('court-listing')->with('success', 'Logged in successfully!');
        }
    }

    // Show Register View
    public function showRegister(Request $request)
    {
        $isAdmin = $request->routeIs('admin.register');

        return view('auth.register', [
            'isAdmin' => $isAdmin,
            'loginRoute' => $isAdmin ? route('admin.login') : route('login'),
            'registerAction' => $isAdmin ? route('admin.register') : route('register'),
        ]);
    }

    // Handle Registration
    public function register(Request $request)
    {
        $customMessages = array_merge(
            $this->nameMessages(),
            $this->emailMessages(),
            $this->phoneMessages(),
            $this->passwordMessages()
        );
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => $this->emailRules(),
            'phone' => $this->phoneRules(),
            'password' => $this->passwordRules(),
        ], $customMessages);

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),

        ]);

        // Auto login the user
        Auth::login($user);

        //return redirect()->route('welcome')->with('success', 'Account created successfully!');
        return redirect('/login')->with('success', 'Account created successfully!');
    }


    // Show Admin Register View
    public function showAdminRegister()
    {
        return view('auth/adminRegister');
    }

    //handle admin registration
    public function adminRegister(Request $request)
    {
        $customMessages = array_merge(
            $this->nameMessages(),
            $this->emailMessages(),
            $this->phoneMessages(),
            $this->passwordMessages()
        );

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => $this->emailRules(),
            'phone' => $this->phoneRules(),
            'password' => $this->passwordRules(),
            'secret_code' => 'required|string',
        ], $customMessages);

        if ($request->secret_code !== env('ADMIN_SECRET_CODE')) {
            return back()->withErrors(['secret_code' => 'Invalid secret code.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        // Auto login the user
        Auth::login($user);

        return redirect('/login')->with('status', 'Admin registered.');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Determine if the user is an admin BEFORE logout
        $isAdmin = $user && $user->is_admin;

        // Perform logout
        Auth::logout();

        // Forget session values
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('is_admin');

        // Redirect based on role
        $redirectRoute = $isAdmin ? route('admin.login') : route('login');

        return redirect($redirectRoute)
            ->with('success', 'Logged out successfully!')
            ->withoutCookie('preferred_theme');
    }

    public function showAccount()
    {
        $user = auth()->user();
        return view('account', compact('user'));
    }

    private function checkPassword(): \Closure
    {
        return function ($attribute, $value, $fail) {
            if (!Hash::check($value, auth()->user()->password)) {
                $fail('The password is incorrect.');
            }
        };
    }
    
    public function updatePassword(Request $request)
    {
        $customMessages = array_merge(
            $this->newPasswordMessages(),
            [
                'current_password.required' => 'Please provide your current password.',
            ]
        );

        $request->validate([
            'current_password' => ['required', $this->checkPassword()],
            'new_password' => array_merge(
                ['required' , 'confirmed'],
                $this->passwordRules()
            ),
        ], $customMessages);

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Custom messages
        $customMessages = $this->phoneMessages(); 

        $request->validate([
            'birthdate'    => 'nullable|date',
            'gender'       => 'nullable|in:male,female,other',
            'phone'        => 'nullable|' . implode('|', $this->phoneRules()), // Allow empty or valid format
            'profile_pic'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $customMessages);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_pics'), $filename);
            $user->profile_pic = 'uploads/profile_pics/' . $filename;
        }

        $user->birthdate = $request->birthdate;
        $user->gender    = $request->gender;

        // Only update phone if provided
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

}

