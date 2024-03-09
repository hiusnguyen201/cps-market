<?php

namespace App\Http\Controllers;

use App\Models\User_Otp;
use App\Models\Role;
use Illuminate\Support\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\InfoSocialRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function localLogin()
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

        User::where("id", $user['id'])->update(['status' => config("constants.user_status.Active")]);

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

    // --- Forget Password Function ---
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::send("emails.forget-Password", ['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });
        return redirect()->to(route("show.forgetpassword.get"))
        ->with("success", "We have send email to reset password.");
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', compact('token'));
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => "required"
        ]);
        $updatePassword = DB::table('password_resets')
        ->where([
            "email" => $request->email,
            "token" => $request->token
        ])->first();
        if (!$updatePassword) {
            return redirect()->to(route('show.resetpassword.get'))->with("error", "Invalid");
        }
        User::where("email", $request->email)
        ->update(["password" => Hash::make($request->password)]);
        DB::table("password_resets")->where(["email" => $request->email])->delete();
        return redirect()->to(route("login"))->with("success", "Password reset success");
    }


}
