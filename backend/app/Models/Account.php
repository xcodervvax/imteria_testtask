<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'yandex_url',
        'yandex_org_id',
        'rating',
        'reviews_count'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
