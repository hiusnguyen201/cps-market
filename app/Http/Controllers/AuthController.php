<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Otp;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\VerificationDirector;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::validate($credentials)) {

            if ($request->has('remember')) {
                $request->session()->put('remember', true);
            } else {
                $request->session()->put('remember', false);
            }

            // Lấy thông tin người dùng từ email
            $user = User::where('email', $credentials['email'])->first();
            $request->session()->put('user', $user);

            $userOTP = $this->generateOTP($user->id);
            $this->sendOtpToEmail($user->email, $userOTP);

            return redirect()->route('OTPverify');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function OTPverify()
    {
        return view('auth.loginOTP');
    }

    public function OTPverify_POST(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = $request->session()->get('user');
        $remember = $request->session()->get('remember');

        $userOTP = User_Otp::where('user_id', $user->id)->first();

        if ($request->otp != $userOTP->otp) {
            // OTP không hợp lệ
            return back()->withErrors([
                'otp' => 'Invalid OTP. Please try again.',
            ]);
        }

        // OTP hợp lệ
        Auth::login($user, $remember);
        $this->deleteOTP($user->id);

        $response = redirect('/');
        return $response;
    }

    public function generateOTP($id)
    {
        $this->deleteOTP($id);

        $otp = mt_rand(100000, 999999);
        User_Otp::updateOrCreate(
            ['otp' => $otp],
            ['user_id' => $id]
        );
        return $otp;
    }

    public function deleteOTP($id)
    {
        User_Otp::where('user_id', $id)->delete();
    }

    public function sendOtpToEmail($email, $otp)
    {
        $email = "ongbeo111@gmail.com";

        Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('OTP Verification');
        });
    }

    public function resendOtp(Request $request)
    {
        $user = $request->session()->get('user');

        $userOTP = $this->generateOTP($user->id);
        $this->sendOtpToEmail($user->email, $userOTP);

        return redirect()->back()->with('success', 'OTP has been resent.');
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect('/');
    }

    public function register() {
        return view('auth.register');
    }

    public function storeRegister(Request $request) {
        $credentials =  $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required'
        ]);
    }
}
