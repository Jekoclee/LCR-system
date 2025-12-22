<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if (empty($user->email_verified_at)) {
                Auth::logout();
                return redirect()->route('verify', ['email' => $user->email])
                    ->with('status', 'Please verify your email using the code we sent.');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
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

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $code = (string) random_int(100000, 999999);
        $user->verification_code = Hash::make($code);
        $user->verification_expires_at = Carbon::now()->addMinutes(30);
        $user->save();

        Mail::to($user->email)->send(new WelcomeMail($user, $code));

        return redirect()->route('verify', ['email' => $user->email])
            ->with('status', 'We have sent a verification code to your email.');
    }

    public function showVerify(Request $request)
    {
        return view('auth.verify', ['email' => $request->query('email')]);
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        if ($user->email_verified_at) {
            return redirect('/')->with('status', 'Email already verified.');
        }

        if (!$user->verification_expires_at || Carbon::now()->greaterThan($user->verification_expires_at)) {
            return back()->withErrors(['code' => 'Verification code has expired.'])->withInput();
        }

        if (!Hash::check($data['code'], (string) $user->verification_code)) {
            return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
        }

        $user->email_verified_at = Carbon::now();
        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('status', 'Email verified. Welcome!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
