<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';

    protected $fillable = [
        'specification_id',
        'key',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'specification_id' => "integer",
        'key' => "string",
    ];

    public function specification():BelongsTo
    {
        return $this->belongsTo(Specification::class);
    }

    public function products_attributes()
    {
        return $this->hasMany(Product_Attribute::class);
    }
}