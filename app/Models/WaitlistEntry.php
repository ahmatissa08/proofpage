<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitlistEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'plan_interest',
        'source',
        'ip_address',
        'user_agent',
        'notified',
    ];

    protected $casts = [
        'notified' => 'boolean',
    ];
}
