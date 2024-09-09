<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class task extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->BelongsTo(category::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(user::class);
    }
}
