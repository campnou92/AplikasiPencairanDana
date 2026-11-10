<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, Auditable;

    protected $primaryKey = 'payment_method_id';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}

