<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function showLogin()
    {
        $isAdmin = request()->routeIs('admin.login');

        return view('auth.login', ['isAdminView' => $isAdmin]);
    }

    public function login(Request $request)
    {
        // 1. Validate that 'login' field is present
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Determine if the input is an email or a name
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // 3. Attempt to authenticate using the determined field
        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Allow all roles to sign in; admin access remains protected by middleware

            // Email Verification Check (Optional for superadmin seeded accounts which are auto-verified)
            if (empty($user->email_verified_at)) {
                $code = (string) random_int(100000, 999999);
                $key = 'pending_verification:' . strtolower($user->email);
                Cache::put($key, ['code_hash' => Hash::make($code)], now()->addMinutes(30));
                Mail::to($user->email)->send(new WelcomeMail(new User(['name' => $user->name, 'email' => $user->email]), $code));
                Auth::logout();

                return redirect()->route('verify', ['email' => $user->email])
                    ->with('status', 'Verification code sent to your email.');
            }

            // Redirect Admins to Dashboard
            if ($user->isAdminOrAbove()) {
                if (Route::has('admin.dashboard')) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect('/admin/dashboard');
            }

            return redirect()->intended(route('home'))->with('status', 'Welcome back, ' . $user->name . '!');
        }

        // 4. Failed login response
        return back()->withErrors([
            'login' => 'Invalid name/email or password.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $code = (string) random_int(100000, 999999);

        $pendingKey = 'pending_registration:' . strtolower($data['email']);
        $pendingData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'code_hash' => Hash::make($code),
        ];
        Cache::put($pendingKey, $pendingData, now()->addMinutes(30));

        $tempUser = new User(['name' => $data['name'], 'email' => $data['email']]);
        $statusMessage = 'We have sent a verification code to your email.';
        try {
            Mail::to($data['email'])->send(new WelcomeMail($tempUser, $code));
        } catch (\Throwable $e) {
            $statusMessage = 'Registration received, but sending email failed. Please try again later.';
        }

        return redirect()->route('verify', ['email' => $data['email']])
            ->with('status', $statusMessage);
    }

    public function showVerify(Request $request)
    {
        return view('auth.verify', ['email' => $request->query('email')]);
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
        ]);

        $existing = User::where('email', $data['email'])->first();
        if ($existing) {
            if (!empty($existing->email_verified_at)) {
                return redirect()->route('home')->with('status', 'Email already verified.');
            }
            $verifyKey = 'pending_verification:' . strtolower($data['email']);
            $pv = Cache::get($verifyKey);
            if (!$pv) {
                return back()->withErrors(['email' => 'No pending verification found or code expired.'])->withInput();
            }
            if (!Hash::check($data['code'], (string) $pv['code_hash'])) {
                return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
            }
            $existing->email_verified_at = Carbon::now();
            $existing->save();
            Cache::forget($verifyKey);
            Auth::login($existing);
            $request->session()->regenerate();
            return redirect()->route('home')->with('status', 'Email verified. Welcome!');
        }

        $pendingKey = 'pending_registration:' . strtolower($data['email']);
        $pending = Cache::get($pendingKey);
        if (!$pending) {
            return back()->withErrors(['email' => 'No pending registration found or code expired. Please register again.']);
        }

        if (!Hash::check($data['code'], (string) $pending['code_hash'])) {
            return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
        }

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'password' => $pending['password_hash'],
        ]);
        $user->email_verified_at = Carbon::now();
        $user->save();

        Cache::forget($pendingKey);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Email verified. Welcome!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (str_contains(url()->previous(), '/admin')) {
            return redirect()->route('admin.login');
        }

        return redirect()->route('home');
    }
}
