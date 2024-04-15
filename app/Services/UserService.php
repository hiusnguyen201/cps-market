<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Jobs\SendPassCreateUser;
use App\Jobs\SendOtp;
use App\Jobs\SendPassResetLink;

use App\Models\User;
use App\Models\Social_Accounts;
use App\Models\Role;
use App\Models\Order;
use App\Models\User_Otp;
use App\Models\Password_Reset;

use Illuminate\Support\Facades\Auth;

class UserService
{
    // Search and Paginate
    public function findAllAndPaginateWithRole($request, $roleName)
    {
        $users = User::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->keyword . '%');
            $query->orWhere('email', 'like', '%' . $request->keyword . '%');
        })->whereHas('role', function ($query) use ($roleName) {
            $query->where('name', '=', $roleName);
        })->orderBy('created_at', 'desc');

        if($request->status && $request->status != "all") {
            $users = $users->where("status", $request->status);
        }

        $users = $users->paginate($request->limit ?? 10);

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
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'status' => $request->status,
                'address' => $request->address,
                'role_id' => $role->id,
                'password' => Hash::make($password)
            ]);

            $details = ["email" => $user->email, "password" => $password];
            SendPassCreateUser::dispatch($details);

            return $user;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                if ($role->name == 'admin') {
                    throw new \Exception("Create user failed");
                } else {
                    throw new \Exception("Create customer failed");
                }
            } else {
                throw new \Exception($e->getMessage());
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
            if ($e->getCode() != 0) {
                if ($user->role->name == 'admin') {
                    throw new \Exception("Edit user failed");
                } else {
                    throw new \Exception("Edit customer failed");
                }
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function deleteUsers($userIds, $roleName)
    {
        $position = null;
        try {
            foreach ($userIds as $index => $userId) {
                if($userId == Auth::id()) {
                    throw new \InvalidArgumentException('Cannot delete this user ' . $index + 1);
                }

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
            if ($e->getCode() != 0) {
                if ($roleName == 'admin') {
                    throw new \Exception("Delete user failed in position " . $position + 1);
                } else {
                    throw new \Exception("Delete customer failed in position " . $position + 1);
                }
            } else {
                throw new \Exception($e->getMessage());
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
            if ($e->getCode() != 0) {
                throw new \Exception('Edit information failed');
            } else {
                throw new \Exception($e->getMessage());
            }
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
            if ($e->getCode() != 0) {
                throw new \Exception('Change password failed');
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function registerCustomer($request)
    {
        try {
            $roleCustomer = Role::where("name", 'customer')->first();
            if(!$roleCustomer) {
                $roleCustomer = Role::create([
                    "name" => "customer"
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => config("constants.user_status.inactive.value"),
                'role_id' => $roleCustomer->id,
                'password' => Hash::make($request->password),
            ]);

            $this->sendOtpToEmail($user);

            return $user;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Register failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function createCustomerWithAccountSocial($request, $accountSocialInfo)
    {
        DB::beginTransaction();
        try {
            $role = Role::where("name", 'customer')->first();
            if(!$role) {
                $role = Role::create([
                    "name" => 'customer'
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Str::random(16),
                'role_id' => $role->id,
            ]);

            Social_Accounts::create([
                "user_id" => $user->id,
                "provider" => $accountSocialInfo['providerName'],
                "provider_user_id" => $accountSocialInfo['id']
            ]);

            $this->sendOtpToEmail($user);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() != 0) {
                throw new \Exception("Register with account social failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function addAccountSocialToCustomer($user, $accountSocialInfo, $provider)
    {
        try {
            $socialAccount = Social_Accounts::create([
                "user_id" => $user->id,
                "provider" => $provider,
                "provider_user_id" => $accountSocialInfo['id']
            ]);

            return $socialAccount;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Add account social to customer failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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

            if ($user->status == config("constants.user_status.inactive")['value']) {
                User::where("id", $user->id)->update([
                    'status' => config("constants.user_status.active")['value'],
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
            if ($e->getCode() != 0) {
                throw new \Exception("Verify Otp failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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
            if ($e->getCode() != 0) {
                throw new \Exception("Send otp to email failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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
            if ($e->getCode() != 0) {
                throw new \Exception("Send link reset password to email failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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
        try {
            $passwordReset = $this->findOnePasswordResetByToken($token);

            if (!$passwordReset) {
                throw new \InvalidArgumentException("Invalid link or link has expired. Please try again!");
            }

            if (Carbon::now()->gt($passwordReset->expire_at)) {
                $passwordReset->delete();
                throw new \InvalidArgumentException("Link has expired. Please try again!");
            }

            return true;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Verify token failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function getRecentOrdersWithLimit($userId, $limit)
    {
        $orders = Order::where("customer_id", $userId)->orderBy('created_at', 'desc')->limit($limit)->get();
        return ($orders && count($orders)) ? $orders : [];
    }

    public function countPlacedOrders($userId)
    {
        $orders = Order::where(function ($query) use ($userId) {
            $query->where("customer_id", $userId);
            $query->where("status", "!=", config("constants.order_status.canceled")['value']);
        })->get();

        return $orders ? count($orders) : 0;
    }

    public function countCancelOrders($userId)
    {
        $orders = Order::where(function ($query) use ($userId) {
            $query->where("customer_id", $userId);
            $query->where("status", "=", config("constants.order_status.canceled")['value']);
        })->get();

        return $orders ? count($orders) : 0;
    }

    public function countProductsAndCalculatePriceInCart($user)
    {
        $countProductsInCart = 0;
        $totalPrice = 0;
        foreach ($user->carts as $cart) {
            if($cart->product) {
                $countProductsInCart += $cart->quantity;
                $totalPrice += (($cart->product->sale_price ? $cart->product->sale_price : $cart->product->price) * $cart->quantity);
            }
        }

        return [$countProductsInCart, $totalPrice];
    }

    public function showOrdersWithFilterInCustomer($userId, $timeSort)
    {
        $orders = Order::where(function ($query) use ($userId, $timeSort) {
            $query->where("customer_id", $userId);
            switch ($timeSort) {
                case '15':
                    $query->where('created_at', '>=', now()->subDays(15));
                    break;
                case '30':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case '180':
                    $query->where('created_at', '>=', now()->subMonths(6));
                    break;
                case 'all':
                    break;
                default:
                    $query->orderBy('created_at', 'desc')->limit(5);
                    break;
            }
        });

        $orders = $orders->paginate(5);
        return $orders && count($orders) ? $orders : [];
    }

    public function countNewCustomers()
    {
        $count = User::where(function ($query) {
            $query->whereDate("created_at", today());
        })->whereHas("role", function ($query) {
            $query->where("name", "customer");
        })->count();

        return $count ? $count : 0;
    }
}