<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Otp extends Model
{
    use HasFactory;

    protected $table = 'user_otp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "otp",
        "user_id",
        "expire"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'otp' => "string",
        'user_id' => "integer",
        "expire" => "datetime"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
