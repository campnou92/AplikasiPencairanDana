<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    use HasFactory, Auditable;

    protected $primaryKey = 'fiscal_year_id';

    protected $fillable = [
        'tahun',
        'is_active',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'is_active' => 'boolean',
    ];

    public static function getActiveYear(): ?int
    {
        return static::where('is_active', true)->value('tahun') ?? (int) date('Y');
    }
}

