<?php

namespace App\Filament\Resources\NpResource\Pages;

use App\Filament\Resources\NpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNps extends ListRecords
{
    protected static string $resource = NpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

