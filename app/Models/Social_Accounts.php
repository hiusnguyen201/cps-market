<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social_Accounts extends Model
{
    use HasFactory;

    protected $table = 'social_accounts';

    protected $fillable = [
        'user_id', 'provider_user_id', 'provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}