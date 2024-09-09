<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class user extends Model
{
   use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
    ];

    public function tasks(): HasMany
    {
        return $this->HasMany(task::class);
    }

}
