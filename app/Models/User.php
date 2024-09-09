<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class user extends Authenticatable
{
   use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    public function tasks(): HasMany
    {
        return $this->HasMany(task::class);
    }

}
