<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    // ----------------------------
    // Login / OTP
    // ----------------------------
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }
// Show registration form
public function showRegisterForm()
{
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.register');
}

// Handle registration
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Optional: send OTP immediately after registration
    $otp = rand(100000, 999999);
    $user->update([
        'otp_code' => $otp,
        'otp_expires_at' => now()->addMinutes(5),
    ]);

    Mail::to($user->email)->send(new OtpMail($otp));
    session(['otp_user_id' => $user->id]);

    return redirect()->route('otp.verify.form')->with('status', 'Registration successful! A 6-digit code has been sent to your email.');
}

  public function login(Request $request)
{
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->login)
                ->orWhere('username', $request->login)
                ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      
        return back()->withErrors(['/' => 'Invalid email/username or password']);
    }
    //   Auth::login($user);
  
    // // Generate OTP
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $user->update([
        'otp_code' => $otp,
        'otp_expires_at' => now()->addMinutes(5),
    ]);

    Mail::to($user->email)->send(new OtpMail($otp));

    // Store OTP session and "remember me" flag
    session([
        'otp_user_id' => $user->id,
        'otp_remember' => $request->has('remember')
    ]);

    return redirect()->route('otp.verify.form')
                     ->with('status', 'We sent a 6-digit code to your email.');
//   $request->session()->put('userRole', $user->role_id);
//         // Regenerate session
//         $request->session()->regenerate();

    

//         return redirect()->route('dashboard')->with('status', 'Login successful!');

}


    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired.']);
        }
        return view('auth.verify-otp');
    }

  public function verifyOtp(Request $request)
{
    // $request->validate(['otp' => 'required|digits:6']);
      // ✅ Validate that all 6 digits are filled
        $validated = $request->validate([
            'digit-1' => 'required|numeric|digits:1',
            'digit-2' => 'required|numeric|digits:1',
            'digit-3' => 'required|numeric|digits:1',
            'digit-4' => 'required|numeric|digits:1',
            'digit-5' => 'required|numeric|digits:1',
            'digit-6' => 'required|numeric|digits:1',
        ]);
      $otp = $request->input('digit-1') .
               $request->input('digit-2') .
               $request->input('digit-3') .
               $request->input('digit-4') .
               $request->input('digit-5') .
               $request->input('digit-6');
    $otpInput = trim($otp);
   
    $user = User::find(session('otp_user_id'));

    if (!$user) {
        return redirect()->route('login')->withErrors(['otp' => 'Session expired.']);
    }

    if ((string)$user->otp_code === $otpInput && $user->otp_expires_at > now()) {
        // Clear OTP
        $user->update(['otp_code' => null, 'otp_expires_at' => null]);

        // Get "remember me" flag
        $remember = session('otp_remember', false);

        // Log user in
        Auth::login($user, $remember);
  $request->session()->put('userRole', $user->role_id);
    $request->session()->put('userId', $user->id );
      $request->session()->put('full_name', $user->full_name);
          $request->session()->put('username', $user->username);
    $request->session()->put('photo', $user->photo );
        // Regenerate session
        $request->session()->regenerate();

        // Clear OTP session data
        session()->forget(['otp_user_id', 'otp_remember']);

        return redirect()->route('dashboard')->with('status', 'Login successful!');
    }

    return back()->withErrors(['otp' => 'Invalid or expired code.']);
}


    public function resendOtp()
    {
        $user = User::find(session('otp_user_id'));
        if (!$user) return redirect()->route('login')->withErrors(['otp' => 'Session expired.']);

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('status', 'A new OTP has been sent.');
    }

    // ----------------------------
    // Logout
    // ----------------------------
    public function logout()
    {
      
        Auth::logout();
        return redirect()->route('login')->with('status', 'Logged out successfully.');
    }

    // ----------------------------
    // Change Password
    // ----------------------------
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('status', 'Password changed successfully.');
    }

    // ----------------------------
    // Forgot / Reset Password
    // ----------------------------
    public function showForgotPasswordForm()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function($user, $password){
                $user->forceFill(['password'=>Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email'=>[__($status)]]);
    }
}
