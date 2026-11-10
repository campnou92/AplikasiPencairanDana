<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiscalYearResource\Pages;
use App\Models\FiscalYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FiscalYearResource extends Resource
{
    protected static ?string $model = FiscalYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Tahun Anggaran';

    protected static ?string $modelLabel = 'Tahun Anggaran';

    protected static ?string $pluralModelLabel = 'Tahun Anggaran';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->minValue(2000)
                    ->maxValue(2100),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiscalYears::route('/'),
            'create' => Pages\CreateFiscalYear::route('/create'),
            'edit' => Pages\EditFiscalYear::route('/{record}/edit'),
        ];
    }
}

