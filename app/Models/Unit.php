<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory, Auditable;

    protected $primaryKey = 'unit_id';

    protected $fillable = [
        'nama_unit',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}

