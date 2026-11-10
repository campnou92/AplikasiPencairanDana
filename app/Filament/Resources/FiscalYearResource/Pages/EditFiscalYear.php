<?php

namespace App\Filament\Resources\FiscalYearResource\Pages;

use App\Filament\Resources\FiscalYearResource;
use App\Models\FiscalYear;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiscalYear extends EditRecord
{
    protected static string $resource = FiscalYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record->is_active) {
            FiscalYear::where('fiscal_year_id', '!=', $this->record->fiscal_year_id)
                ->update(['is_active' => false]);
        }
    }
}

