<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $fillable = [
        'access_token',
        'refresh_token',
        'user_id',
        'created_at',
        'updated_at',
    ];

}
