<?php

namespace App\Filament\Resources\NpResource\Pages;

use App\Filament\Resources\NpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNp extends EditRecord
{
    protected static string $resource = NpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

