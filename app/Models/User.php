<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        "phone",
        "status",
        "gender",
        "role_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => "string",
        'email' => "string",
        'password' => "string",
        "phone" => "string",
        "status" => "integer",
        "gender" => "integer",
        "role_id" => "integer",
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function otp(): HasOne
    {
        return $this->hasOne(User_Otp::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function password_reset(): HasOne
    {
        return $this->hasOne(Password_Reset::class);
    }
}