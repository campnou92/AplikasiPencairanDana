<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory, Auditable;

    protected $primaryKey = 'expense_type_id';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}

