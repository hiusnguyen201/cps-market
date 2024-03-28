<?php

namespace App\Http\Controllers\Web;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

use App\Models\PasswordResets;
use App\Models\User_Otp;
use App\Models\Role;
use App\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\InfoSocialRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

use App\Jobs\SendOtp;

class AuthController extends Controller
{
    public function localLogin()
    {
        return view('auth.login', [
            'title' => 'Login | Cps Market'
        ]);
    }

    public function handleLocalLogin(LoginRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            session()->flash('error', 'Email or password is incorrect');
            return redirect()->back();
        }

        $user = Auth::user();
        if ($user->status == config("constants.user_status.Active")) {
            $role = Role::where("name", "customer")->first();
            Auth::login($user, true);
            return $role ? redirect("/member") : redirect("/admin");
        } else {
            $this->sendOtpToEmail($user);
            session()->flash('success', "We've sent a verification code to your email");
            return redirect("/auth/otp");
        }
    }

    public function otp()
    {
        return view('auth.otp', [
            'title' => 'Otp | Cps Market'
        ]);
    }

    public function handleVerifyOtp(OtpRequest $request)
    {
        $user = Auth::user();
        $user_otp = User_Otp::where('user_id', $user->id)->where('otp', $request->otp)->first();

        if (is_null($user_otp)) {
            session()->flash('error', 'Invalid OTP! Please try again.');
            return redirect()->back();
        }

        if ($user->status == config("constants.user_status.Inactive")) {
            User::where("id", $user->id)->update(['status' => config("constants.user_status.Active"), 'email_verified_at' => Carbon::now()]);
        }

        if (Carbon::now()->gt($user_otp->expire)) {
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
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/auth/login');
    }

    public function infoSocial()
    {
        $social_user_info = session()->get('social_user_info');

        if (!$social_user_info) {
            return redirect("/auth/login");
        }

        return view("auth.socialUpdateInfo", ['name' => $social_user_info[0]['name'], 'email' => $social_user_info[0]['email']]);
    }

    public function handleUpdateInfoSocial(InfoSocialRequest $request)
    {
        try {
            $social_user_info = session()->get('social_user_info')[0];

            $role = Role::where("name", 'customer')->first();
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'role_id' => $role['id'],
                'google_id' => $social_user_info['provider'] == 'google' ? $social_user_info['id'] : null,
                'facebook_id' => $social_user_info['provider'] == 'facebook' ? $social_user_info['id'] : null
            ]);

            session()->forget('social_user_info');
            session()->flash('success', "We've sent a verification code to your email");
            $this->sendOtpToEmail($user);
            return redirect("/auth/otp");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash("error", "Update info account failed");
            return redirect()->back();
        }
    }

    public function socialLogin($provider = null)
    {
        if (!config("services.$provider"))
            abort('404');
        return Socialite::driver($provider)->redirect();
    }

    public function handleSocialLogin($provider = null)
    {
        /*
            Khi mà social trả về thông tin người dùng
            - Cần kiểm tra người dùng có tồn tại với email đc trả về hay ko
                + Ko tồn tại, render /auth/update-info-social -> tao user (Inactive) -> xác nhận otp (active)
                + Nếu tồn tại, update id của social vào user đó, kiem tra active -> /auth/update-inactive-account
        */

        $social_user_info = Socialite::driver($provider)->user();
        if (!$social_user_info)
            return redirect()->back();
        $social_user_info['provider'] = $provider;

        try {
            $exist_user = User::where(["email" => $social_user_info['email']])->first();
            if (is_null($exist_user)) {
                if (!session()->get('social_user_info'))
                    session()->push("social_user_info", $social_user_info);
                return redirect("/auth/info-social");
            }

            User::where("id", $exist_user['id'])->update([
                'google_id' => $provider == 'google' ? $social_user_info['id'] : null,
                'facebook_id' => $provider == 'facebook' ? $social_user_info['id'] : null
            ]);

            if ($exist_user->status == config("constants.user_status.Inactive")) {
                Auth::login($exist_user);
                session()->flash('success', "We've sent a verification code to your email");
                $this->sendOtpToEmail($exist_user);
                return redirect("/auth/otp");
            } else {
                Auth::login($exist_user, true);
                return redirect("/");
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', "Login with social error");
            return redirect("/auth/login");
        }
    }

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register | Cps Market'
        ]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        $role = Role::where("name", 'customer')->first();

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $role['id'],
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            Auth::login($user);
            $this->sendOtpToEmail($user);
            session()->flash('success', "Registration successful! We've sent a verification code to your email");
            return redirect("/auth/otp");
        }
    }

    public function forgetPassword()
    {
        return view('auth.forgetPassword', [
            'title' => 'Forget Password | Cps Market'
        ]);
    }

    public function handleForgetPassword(ForgetPasswordRequest $request)
    {
        //search
        $resetPassword = PasswordResets::where('email', $request['email'])->first();
        if ($resetPassword) {
            if (Carbon::now()->gt($resetPassword['expire_at'])) {
                PasswordResets::where('email', $request['email'])->delete();
            } else {
                return redirect('/auth/forget-password')
                    ->with("success", "Mail was sent. Please check your mail again!");
            }
        }

        $token = null;
        do {
            $token = Str::random(64);
            $resetPassword = PasswordResets::where('token', $token)->first();
        } while ($resetPassword);

        PasswordResets::create([
            'email' => $request['email'],
            'token' => $token,
            'created_at' => Carbon::now(),
            'expire_at' => Carbon::now()->addMinutes(env('PASS_RESET_EXPIRE_MINUTES', 1)),
        ]);

        Mail::send("mail.forget-Password", ['token' => $token], function ($message) use ($request) {
            $message->to($request['email']);
            $message->subject("Reset Password");
        });

        return redirect('/auth/forget-password')
            ->with("success", "Mail was sent. Please check your mail!");
    }

    public function changePasswordForm($token)
    {
        $passwordReset = PasswordResets::where('token', $token)->first();

        if (!$passwordReset) {
            return redirect('/auth/forget-password')
                ->with("error", "Invalid link or link has expired. Please try again!");
        }

        if (Carbon::now()->gt($passwordReset->expire_at)) {
            PasswordResets::where('token', $token)->delete();
            return redirect('/auth/forget-password')
                ->with("error", "Link has expired. Please try again!");
        }

        return view('auth.changePassword', [
            'title' => 'Change Password | Cps Market',
            'token' => $token
        ]);
    }

    public function handleChangePassword(ResetPasswordRequest $request)
    {

        $updatePassword = PasswordResets::where([
            "token" => $request->token
        ])->first();
        if (!$updatePassword) {
            $url = '/auth/reset-password/' . $request->token;
            return redirect()->to($url)->with("error", "Invalid");
        }

        User::where("email", $updatePassword->email)
            ->update(["password" => Hash::make($request['password'])]);
        PasswordResets::where(["email" => $updatePassword->email])->delete();
        return redirect('/auth/login')->with('success', 'Password reset successful');
    }

    public function sendOtpToEmail($user)
    {
        User_Otp::where('user_id', $user->id)->delete();

        $otp = mt_rand(100000, 999999);
        User_Otp::create([
            'otp' => $otp,
            'expire' => Carbon::now()->addMinutes(env('OTP_EXPIRE_MINUTES', 1)),
            'user_id' => $user->id
        ]);

        $details = ["email" => $user->email, "otp" => $otp];
        SendOtp::dispatch($details);

        return;
    }
}
