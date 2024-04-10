<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Jobs\SendPassCreateUser;
use App\Jobs\SendOtp;
use App\Jobs\SendPassResetLink;

use App\Services\OtpService;

use App\Models\User;
use App\Models\Social_Account;
use App\Models\Role;
use App\Models\User_Otp;
use App\Models\Password_Reset;

class UserService
{
    // Search and Paginate
    public function findAllAndPaginateWithRole($request, $roleName)
    {
        $users = User::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->kw . '%');
            $query->orWhere('email', 'like', '%' . $request->kw . '%');
        })->whereHas('role', function ($query) use ($roleName) {
            $query->where('name', '=', $roleName);
        });

        if ($request->status) {
            $users = $users->where('status', $request->status);
        }

        $users = $users->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return $users && count($users) ? $users : [];
    }

    public function findAllWithRole($roleName)
    {
        $users = User::whereHas('role', function ($query) use ($roleName) {
            $query->where("name", "=", $roleName);
        })->get();

        return $users && count($users) ? $users : [];
    }
    public function findOneById($id)
    {
        $user = User::find($id);
        return $user ? $user : [];
    }

    public function createUserWithRole($request, $role)
    {
        try {
            $password = Str::random(16);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'gender' => $request['gender'],
                'role_id' => $role->id,
                'password' => Hash::make($password)
            ]);

            $details = ["email" => $user->email, "password" => $password];
            SendPassCreateUser::dispatch($details);

            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            if ($role->name == 'admin') {
                throw new \Exception("Create user failed");
            } else {
                throw new \Exception("Create customer failed");
            }
        }
    }

    public function updateUser($request, $user)
    {
        try {
            $request->request->add(['updated_at' => now()]);
            $user->fill($request->input());
            $user->save();

            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            if ($user->role->name == 'admin') {
                throw new \Exception("Edit user failed");
            } else {
                throw new \Exception("Edit customer failed");
            }
        }
    }

    public function deleteUsers($userIds, $roleName)
    {
        $position = null;
        try {
            foreach ($userIds as $index => $userId) {
                $user = User::find($userId);

                if (!$user) {
                    if ($roleName == 'admin') {
                        throw new \InvalidArgumentException('User is not found in position ' . $index + 1);
                    } else {
                        throw new \InvalidArgumentException('Customer is not found in position ' . $index + 1);
                    }
                }

                $status = $user->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            if ($roleName == 'admin') {
                throw new \Exception("Delete user failed in position " . $position + 1);
            } else {
                throw new \Exception("Delete customer failed in position " . $position + 1);
            }
        }
    }

    public function updateInfoMember($request, $user)
    {
        try {
            $request->request->add(['updated_at' => now()]);
            $user->fill($request->input());
            $user->save();

            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Edit information failed');
        }
    }

    public function changePassword($user, $newPassword, $oldPassword = null)
    {
        try {
            if ($oldPassword) {
                if (!Hash::check($oldPassword, $user->password)) {
                    throw new \InvalidArgumentException('Current password is incorrect');
                }
            }

            $user->update([
                'password' => Hash::make($newPassword),
                'updated_at' => now()
            ]);

            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Change password failed');
        }
    }

    public function registerCustomer($request)
    {
        try {
            $role = Role::where("name", 'customer')->first();

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'role_id' => $role->id,
                'password' => Hash::make($request->password),
            ]);

            $this->otpService->sendOtpToEmail($user);

            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Register failed");
        }
    }

    public function createCustomerWithAccountSocial($request, $accountSocialInfo)
    {
        DB::beginTransaction();
        try {
            $role = Role::where("name", 'customer')->first();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $role->id,
            ]);

            Social_Account::create([
                "user_id" => $user->id,
                "provider" => $accountSocialInfo->provider,
                "provider_user_id" => $accountSocialInfo->id
            ]);

            $this->otpService->sendOtpToEmail($user);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            DB::rollBack();
            throw new \Exception("Register with account social failed");
        }
    }

    public function addAccountSocialToCustomer($user, $accountSocialInfo, $provider)
    {
        try {
            $socialAccount = Social_Account::create([
                "user_id" => $user->id,
                "provider" => $provider,
                "provider_user_id" => $accountSocialInfo['id']
            ]);

            return $socialAccount;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Add account social to customer failed");
        }
    }

    public function findOneByEmail($email)
    {
        if (!$email) {
            return null;
        }

        $user = User::where("email", $email)->first();
        return $user ? $user : null;
    }

    public function verifyOtp($otp, $user)
    {
        try {
            $user_otp = User_Otp::where([
                'user_id' => $user->id,
                'otp' => $otp
            ])->first();

            if (!$user_otp) {
                throw new \InvalidArgumentException('Invalid OTP! Please try again');
            }

            if ($user->status == config("constants.user_status.Inactive")) {
                User::where("id", $user->id)->update([
                    'status' => config("constants.user_status.Active"),
                    'email_verified_at' => Carbon::now()
                ]);
            }

            if (Carbon::now()->gt($user_otp->expire)) {
                $user_otp->delete();
                throw new \InvalidArgumentException('Otp is expired');
            }

            $user_otp->delete();

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Verify Otp failed");
        }
    }

    public function sendOtpToEmail($user)
    {
        try {
            $existOtp = User_Otp::where('user_id', $user->id);
            if ($existOtp) {
                $existOtp->delete();
            }

            $otp = mt_rand(100000, 999999);
            User_Otp::create([
                'otp' => $otp,
                'expire' => Carbon::now()->addMinutes(env('OTP_EXPIRE_MINUTES', 1)),
                'user_id' => $user->id
            ]);

            $details = ["email" => $user->email, "otp" => $otp];
            SendOtp::dispatch($details);

            return;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Send otp to email failed");
        }
    }
    public function sendLinkResetPasswordToEmail($user)
    {
        try {
            if ($user->password_reset) {
                if (Carbon::now()->gt($user->password_reset->expire)) {
                    Password_Reset::where(["user_id" => $user->id])->delete();
                } else {
                    throw new \InvalidArgumentException("Mail was sent. Please check your mail again!");
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

            return;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Send link reset password to email failed");
        }
    }

    public function findOnePasswordResetByToken($token)
    {
        $passwordReset = Password_Reset::where([
            "token" => $token
        ])->first();

        return $passwordReset ? $passwordReset : null;
    }

    public function verifyTokenRestPassword($token)
    {
        $passwordReset = $this->findOnePasswordResetByToken($token);

        if (!$passwordReset) {
            throw new \InvalidArgumentException("Invalid link or link has expired. Please try again!");
        }

        if (Carbon::now()->gt($passwordReset->expire_at)) {
            $passwordReset->delete();
            throw new \InvalidArgumentException("Link has expired. Please try again!");
        }

        return true;
    }
}