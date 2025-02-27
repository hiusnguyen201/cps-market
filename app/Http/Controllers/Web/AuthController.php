<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\InfoSocialRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

use App\Services\CategoryService;
use App\Services\UserService;
use Exception;

class AuthController extends Controller
{
    private CategoryService $categoryService;
    private UserService $userService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
    }

    public function localLogin()
    {
        $categories = $this->categoryService->findAll();

        return view('auth.login', [
            'title' => 'Login',
            'categories' => $categories
        ]);
    }

    public function handleLocalLogin(LoginRequest $request)
    {
        if (
            !Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])
        ) {
            session()->flash('error', 'Email or password is incorrect');
            return redirect("/auth/login");
        }

        $user = Auth::user();
        if ($user->status == config("constants.user_status.active.value")) {
            session()->flash("success", "Login successfully");
            return $user->role->name == 'customer' ? redirect("/member") : redirect("/admin");
        } else if ($user->status == config("constants.user_status.locked.value")) {
            return redirect("/auth/login")->with("error", "This account is locked");
        }

        try {
            $this->userService->sendOtpToEmail(Auth::user());
            return redirect("/auth/otp")->with("success", "We've sent a verification code to your email");
        } catch (\Exception $e) {
            return redirect("/auth/login")->with("error", $e->getMessage());
        }
    }

    public function otp()
    {
        $categories = $this->categoryService->findAll();
        return view('auth.otp', [
            'title' => 'Otp',
            'categories' => $categories
        ]);
    }

    public function handleVerifyOtp(OtpRequest $request)
    {
        $user = Auth::user();

        try {
            $this->userService->verifyOtp($request->otp, $user);
        } catch (\Exception $e) {
            return redirect("/auth/otp")->with("error", $e->getMessage());
        }

        Auth::login($user, true);
        session()->flash("success", "Login successfully");
        if ($user->role->name === 'customer') {
            return redirect("/member");
        } else {
            return redirect("/admin");
        }
    }

    public function handleResendOtp()
    {
        try {
            $this->userService->sendOtpToEmail(Auth::user());
            session()->flash('success', 'Otp has been resent');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

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

        $categories = $this->categoryService->findAll();
        return view("auth.socialUpdateInfo", [
            'name' => $userSocial->name,
            'email' => $userSocial->email,
            'categories' => $categories,
            "title" => "Info Social Account"
        ]);
    }

    public function handleCreateWithAccountSocial(InfoSocialRequest $request)
    {
        try {
            $userSocial = session()->get('userSocial');
            $user = $this->userService->createCustomerWithAccountSocial($request, $userSocial);
            session()->forget('userSocial');
            Auth::login($user, true);
            return redirect("/auth/otp")->with('success', "We've sent a verification code to your email");
        } catch (\Exception $e) {
            return redirect("/auth/info-social")->with("error", $e->getMessage());
        }
    }

    public function socialLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleSocialLogin($provider)
    {
        try {
            $accountSocialInfo = Socialite::driver($provider)->stateless()->user();
            if (!$accountSocialInfo) {
                return redirect()->back();
            }

            $user = $this->userService->findOneByEmail($accountSocialInfo['email']);
            if (!$user) {
                $accountSocialInfo['providerName'] = $provider;
                session()->put('userSocial', $accountSocialInfo);
                return redirect("/auth/info-social");
            }

            $exist_social = $user->social_accounts->filter(function ($item) use ($accountSocialInfo) {
                return $item['provider_user_id'] == $accountSocialInfo['id'];
            });

            if (!count($exist_social)) {
                try {
                    $this->userService->addAccountSocialToCustomer($user, $accountSocialInfo, $provider);
                } catch (\Exception $e) {
                    return redirect("/auth/login")->with('error', $e->getMessage());
                }
            }

            Auth::login($user, true);
            if ($user->status == config("constants.user_status.inactive.value")) {
                $this->userService->sendOtpToEmail($user);
                return redirect("/auth/otp")->with('success', "We've sent a verification code to your email");
            } else if ($user->status == config("constants.user_status.locked.value")) {
                return redirect("/auth/login")->with("error", "This account is locked");
            } else {
                session()->flash("success", "Login successfully");
                return redirect("/member");
            }
        } catch (\Exception $e) {
            return redirect("/auth/login")->with("error", "Login with " . $provider . " failed");
        }
    }

    public function register()
    {
        $categories = $this->categoryService->findAll();
        return view('auth.register', [
            'title' => 'Register',
            "categories" => $categories,
        ]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        try {
            $user = $this->userService->registerCustomer($request);
            Auth::login($user, true);
            return redirect("/auth/otp")->with("success", "Registration successfully! We've sent a verification code to your email");
        } catch (\Exception $e) {
            return redirect("/auth/register")->with("error", $e->getMessage());
        }
    }

    public function forgetPasswordForm()
    {
        $categories = $this->categoryService->findAll();
        return view('auth.forgetPassword', [
            'title' => 'Forget Password',
            'categories' => $categories,
        ]);
    }

    public function handleForgetPassword(ForgetPasswordRequest $request)
    {
        try {
            $user = $this->userService->findOneByEmail($request->email);
            if (!$user || $user->deleted_at) {
                throw new Exception("User not found!");
            }

            $this->userService->sendLinkResetPasswordToEmail($user);
            session()->flash("success", "Mail was sent. Please check your mail!");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
        }

        return redirect("/auth/forget-password");
    }

    public function changePasswordForm($token)
    {
        try {
            $this->userService->verifyTokenRestPassword($token);
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect('/auth/forget-password');
        }

        $categories = $this->categoryService->findAll();
        return view('auth.changePassword', [
            'title' => 'Change Password',
            'categories' => $categories,
            'token' => $token
        ]);
    }

    public function handleChangePassword(ResetPasswordRequest $request, $token)
    {
        try {
            $passwordReset = $this->userService->findOnePasswordResetByToken($token);
            if (!$passwordReset) {
                return redirect("/auth/forget-password/" . $token)->with("error", "Invalid link or link has expired. Please try again!");
            }

            $this->userService->changePassword($passwordReset->user, $request->password);
            $passwordReset->delete();

            return redirect('/auth/login')->with('success', 'Reset password successfully');
        } catch (\Exception $e) {
            return redirect("/auth/change-password/" . $token)->with("error", $e->getMessage());
        }
    }
}
