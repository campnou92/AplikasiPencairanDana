<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Np extends Model
{
    use HasFactory, Auditable;

    protected $primaryKey = 'np_id';

    protected $fillable = [
        'kode_np',
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}

