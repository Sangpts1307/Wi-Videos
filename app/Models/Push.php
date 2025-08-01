<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'user_id',
        'status',
        'created_at',
        'updated_at'
    ];
}
