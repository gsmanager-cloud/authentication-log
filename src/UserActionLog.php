<?php

namespace GSManager\AuthenticationLog;

use GSManager\Database\Eloquent\Model;

class UserActionLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'level',
        'data',
        'ip',
        'user_agent',
        'referrer',
        'url',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
