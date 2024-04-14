<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_Otp>
 */
class User_OtpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'otp' => mt_rand(100000, 999999),
            'user_id' => User::factory(),
            'expire' => Carbon::now()->addMinutes(env('OTP_EXPIRE_MINUTES', 1))
        ];
    }
}