<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handleLocalLogin(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $this->sendOtpToEmail($user);
            session()->flash('success', "We've sent a verification code to your email");
            return redirect("/auth/otp");
        }

        session()->flash('error', 'Email or password is incorrect');
        return redirect()->back();
    }

    public function sendOtpToEmail($user)
    {
        $user_otp_exists = User_Otp::where('user_id', $user->id);

        if (!is_null($user_otp_exists)) {
            $user_otp_exists->delete();
        }

        $user_otp_new = User_Otp::create([
            'otp' => mt_rand(100000, 999999),
            'expire' => date('Y-m-d H:i:s', strtotime(now()) + 60 * env('OTP_EXPIRE_MINUTES', 1)),
            'user_id' => $user->id
        ]);

        Mail::raw("Your OTP is: $user_otp_new->otp", function ($message) use ($user) {
            $message->to($user->email)->subject('OTP Verification');
        });

        return true;
    }

    public function otp()
    {
        return view('auth.otp');
    }

    public function handleVerifyOtp(OtpRequest $request)
    {
        $user = Auth::user();
        $user_otp = User_Otp::where('user_id', $user->id)->where('otp', $request->otp)->first();

        if (is_null($user_otp)) {
            session()->flash('error', 'Invalid Otp! Please try again.');
            return redirect()->back();
        }

        if (strtotime($user_otp->expire) - strtotime(now()) < 0) {
            $user_otp->delete();
            session()->flash('error', 'Otp is expired!');
            return redirect()->back();
        }

        Auth::login($user, true);
        $user_otp->delete();

        if ($user->role->name === 'customer') {
            return redirect("/");
        } else {
            return redirect("/admin");
        }
    }

    public function handleResendOtp()
    {
        $this->sendOtpToEmail(Auth::user());
        session()->flash('success', 'Otp has been resent!');
        return redirect("/auth/otp");
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect('/');
    }
}
