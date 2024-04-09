<?php

namespace App\Http\Controllers\Web;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

use App\Models\Password_Reset;
use App\Models\User_Otp;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Social_Account;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\InfoSocialRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

use App\Jobs\SendOtp;
use App\Jobs\SendPassResetLink;

class AuthController extends Controller
{
    public function localLogin()
    {
        $categories = Category::all();
        return view('auth.login', [
            'title' => 'Login',
            'categories' => $categories
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
        $categories = Category::all();
        return view('auth.otp', [
            'title' => 'Otp',
            'categories' => $categories
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
        $userSocial = session()->get('userSocial');

        if (!$userSocial) {
            return redirect("/auth/login");
        }

        $categories = Category::all();
        return view("auth.socialUpdateInfo", ['name' => $userSocial->name, 'email' => $userSocial->email, 'categories' => $categories, "title" => "Info Social Account"]);
    }

    public function handleUpdateInfoSocial(InfoSocialRequest $request)
    {
        try {
            $userSocial = session()->get('userSocial');

            $role = Role::where("name", 'customer')->first();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $role->id,
            ]);

            Social_Account::create([
                "user_id" => $user->id,
                "provider" => $userSocial->provider,
                "provider_user_id" => $userSocial->id
            ]);

            session()->forget('userSocial');

            Auth::login($user);
            $this->sendOtpToEmail($user);
            return redirect("/auth/otp")->with('success', "We've sent a verification code to your email");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return redirect()->back()->with("error", "Update info account failed");
        }
    }

    public function socialLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleSocialLogin($provider)
    {
        /*
            Khi mà social trả về thông tin người dùng
            - Cần kiểm tra người dùng có tồn tại với email đc trả về hay ko
                + Ko tồn tại, render /auth/update-info-social -> tao user (Inactive) -> xác nhận otp (active)
                + Nếu tồn tại, update id của social vào user đó, kiem tra active -> /auth/update-inactive-account
        */

        $userSocial = Socialite::driver($provider)->stateless()->user();
        if (!$userSocial) return redirect()->back();

        try {
            $exist_user = User::where(["email" => $userSocial['email']])->first();
            if (!$exist_user) {
                $userSocial->provider = $provider;
                session()->put('userSocial', $userSocial);
                return redirect("/auth/info-social");
            }

            Social_Account::create([
                "user_id" => $exist_user['id'],
                "provider" => $provider,
                "provider_user_id" => $userSocial['id']
            ]);

            if ($exist_user->status == config("constants.user_status.Inactive")) {
                Auth::login($exist_user);
                $this->sendOtpToEmail($exist_user);
                return redirect("/auth/otp")->with('success', "We've sent a verification code to your email");
            } else {
                Auth::login($exist_user, true);
                return redirect("/");
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return redirect("/auth/login")->with('error', "Login with social error");
        }
    }

    public function register()
    {
        $categories = Category::all();
        return view('auth.register', [
            'title' => 'Register',
            "categories" => $categories,
        ]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        $role = Role::where("name", 'customer')->first();

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $role->id,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            Auth::login($user);
            $this->sendOtpToEmail($user);
            session()->flash('success', "Registration successful! We've sent a verification code to your email");
            return redirect("/auth/otp");
        }
    }

    public function forgetPasswordForm()
    {
        $categories = Category::all();
        return view('auth.forgetPassword', [
            'title' => 'Forget Password',
            'categories' => $categories,
        ]);
    }

    public function handleForgetPassword(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->password_reset) {
            if (Carbon::now()->gt($user->password_reset->expire)) {
                Password_Reset::where(["user_id" => $user->id])->delete();
            } else {
                return redirect()->back()->with("success", "Mail was sent. Please check your mail again!");
            }
        }

        $token = Str::random(64);
        Password_Reset::create([
            'user_id' => $user->id,
            'token' => $token,
            'expire' => Carbon::now()->addMinutes(env('PASS_RESET_EXPIRE_MINUTES', 1)),
        ]);

        $details = ["email" => $user->email, "token" => $token];
        SendPassResetLink::dispatch($details);

        return redirect()->back()->with("success", "Mail was sent. Please check your mail!");
    }

    public function changePasswordForm($token)
    {
        $passwordReset = Password_Reset::where('token', $token)->first();

        if (!$passwordReset) {
            return redirect('/auth/forget-password')
                ->with("error", "Invalid link or link has expired. Please try again!");
        }

        if (Carbon::now()->gt($passwordReset->expire_at)) {
            Password_Reset::where('token', $token)->delete();
            return redirect('/auth/forget-password')
                ->with("error", "Link has expired. Please try again!");
        }

        $categories = Category::all();

        return view('auth.changePassword', [
            'title' => 'Change Password',
            'categories' => $categories,
            'token' => $token
        ]);
    }

    public function handleChangePassword(ResetPasswordRequest $request)
    {
        $passwordReset = Password_Reset::where([
            "token" => $request->token
        ])->first();
        if (!$passwordReset) {
            $url = '/auth/reset-password/' . $request->token;
            return redirect()->to($url)->with("error", "Invalid");
        }

        $passwordReset->user->update(["password" => Hash::make($request->password)]);
        $passwordReset->delete();

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
