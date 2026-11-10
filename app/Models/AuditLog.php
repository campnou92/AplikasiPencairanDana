<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'actor',
        'action',
        'entity',
        'entity_id',
        'timestamp',
        'before_after',
        'reason',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'before_after' => 'array',
    ];
}

