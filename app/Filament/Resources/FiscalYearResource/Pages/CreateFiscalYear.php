<?php

namespace App\Filament\Resources\FiscalYearResource\Pages;

use App\Filament\Resources\FiscalYearResource;
use App\Models\FiscalYear;
use Filament\Resources\Pages\CreateRecord;

class CreateFiscalYear extends CreateRecord
{
    protected static string $resource = FiscalYearResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->is_active) {
            FiscalYear::where('fiscal_year_id', '!=', $this->record->fiscal_year_id)
                ->update(['is_active' => false]);
        }
    }
}

