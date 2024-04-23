<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_Reset extends Model
{
    use HasFactory;

    protected $table = 'password_reset';

    protected $fillable = [
        'user_id',
        'token',
        "expire",
    ];

    protected $casts = [
        'user_id' => "integer",
        'token' => "string",
        "expire" => "datetime"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
